<?php
/**
 * Base Prompt Templates Configuration
 *
 * This file contains the base prompt templates for each product type.
 * Templates support variable substitution using [VARIABLE_NAME] placeholders.
 *
 * Available variables:
 * - [STYLE] - From style_preset field
 * - [ROOM_TYPE] - From room_type field (interior renders)
 * - [BUILDING_TYPE] - From building_type field (exterior renders)
 * - [SPACE_TYPE] - From space_type field (panoramas)
 * - [PLAN_TYPE] - From plan_type field (floorplans)
 * - [VIEW_ANGLE] - From view_angle field (3D floorplans)
 * - [QUALITY] - From quality field
 * - [ADDITIONAL_INSTRUCTIONS] - User input from additional instructions field
 */

function getBasePrompts() {
    return [
        'interior_render' => 'Transform this [ROOM_TYPE] interior render into a beautifully styled [STYLE] space while maintaining exact architectural integrity:

CRITICAL - PRESERVE EXISTING STRUCTURE:
- Keep all wall positions, angles, and dimensions exactly as shown
- Maintain exact door locations, sizes, and swing directions
- Preserve all window placements, sizes, and frame styles
- Keep ceiling height, moldings, and architectural details unchanged
- Maintain floor boundaries and room shape precisely
- Do not alter any built-in elements, outlets, or fixtures positions

ROOM TYPE: [ROOM_TYPE]
STYLE: [STYLE]
QUALITY: [QUALITY]

STYLE REQUIREMENTS:
[ADDITIONAL_INSTRUCTIONS]

ATMOSPHERE:
- Night time scene with warm interior lighting
- Summer ambiance (consider open windows if present, light curtains)
- Photorealistic rendering quality

FURNITURE & DECORATION:
- Add furniture appropriate for a [ROOM_TYPE]
- Position pieces to maintain clear pathways to all doors
- Ensure furniture doesn\'t block windows or architectural features
- Include decorative elements that complement the [STYLE] style
- Keep the space functional and livable

FINAL CHECK:
Before generating, verify that NO walls, doors, windows, or structural elements have shifted from their original positions. Only ADD elements, do not MODIFY the architecture.',

        'exterior_render' => 'Reimagine this [BUILDING_TYPE] exterior architectural render in [STYLE] style while preserving structural integrity:

CRITICAL - PRESERVE EXISTING STRUCTURE:
- Maintain the building\'s exact dimensions and proportions
- Keep all window and door placements unchanged
- Preserve the roofline, height, and overall massing
- Maintain structural columns, beams, and load-bearing elements
- Keep the foundation and ground level unchanged

BUILDING TYPE: [BUILDING_TYPE]
STYLE: [STYLE]
QUALITY: [QUALITY]

STYLE REQUIREMENTS:
[ADDITIONAL_INSTRUCTIONS]

MATERIALS & FINISHES:
- Apply appropriate exterior materials for a [BUILDING_TYPE] in [STYLE] style
- Update facade treatments while maintaining structural openings
- Add or modify non-structural elements like railings, trim, and details
- Ensure material choices are contextually appropriate

ENVIRONMENT & ATMOSPHERE:
- Photorealistic rendering quality
- Natural daylight with appropriate shadows
- Include appropriate landscaping and context for a [BUILDING_TYPE]
- Maintain proper scale and perspective

FINAL CHECK:
Verify that the building\'s core structure, dimensions, and openings remain unchanged. Only surface treatments and non-structural elements should be modified.',

        'panorama_image' => 'Transform this [SPACE_TYPE] wide-angle panoramic view into a [STYLE] environment:

PANORAMIC INTEGRITY:
- Maintain proper perspective and horizon alignment across the entire view
- Preserve spatial relationships and depth
- Ensure seamless continuity from left to right
- Keep the field of view and viewing angle unchanged

SPACE TYPE: [SPACE_TYPE]
STYLE: [STYLE]
QUALITY: [QUALITY]

STYLE REQUIREMENTS:
[ADDITIONAL_INSTRUCTIONS]

ATMOSPHERE & LIGHTING:
- Consistent lighting across the entire panorama
- Natural progression of shadows and highlights
- Photorealistic quality throughout
- Appropriate environmental context for a [SPACE_TYPE]

COMPOSITION:
- Balance visual elements across the wide field of view
- Maintain focal points and visual flow
- Ensure edge continuity if applicable
- Preserve the panoramic sense of scale and openness',

        '360_panorama' => 'Transform this [SPACE_TYPE] 360-degree panoramic view into a [STYLE] environment:

360-DEGREE INTEGRITY:
- Maintain perfect spatial continuity across the full 360-degree view
- Ensure seamless edges where the panorama wraps around
- Preserve the spherical perspective and distortion characteristics
- Keep the horizon line level and consistent (if maintain_horizon is enabled)
- Maintain proper vertical perspective from floor to ceiling

SPACE TYPE: [SPACE_TYPE]
STYLE: [STYLE]
QUALITY: [QUALITY]

STYLE REQUIREMENTS:
[ADDITIONAL_INSTRUCTIONS]

LIGHTING & ATMOSPHERE:
- Consistent lighting throughout the 360-degree [SPACE_TYPE] space
- Natural light distribution considering the full environment
- Shadows and reflections that make sense from all viewing angles
- Photorealistic quality with proper exposure balance

SPATIAL COHERENCE:
- Elements should work together when viewed from any direction
- Maintain realistic spatial relationships in all directions
- Ensure color and material consistency throughout
- Preserve the immersive quality of the 360-degree experience

FINAL CHECK:
Verify that the panorama wraps seamlessly and maintains spatial coherence from every viewing angle.',

        '3d_floorplan' => 'Redesign this [PLAN_TYPE] 3D floor plan visualization in [STYLE] style with [VIEW_ANGLE] view:

FLOORPLAN INTEGRITY:
- Maintain the exact floor plan layout and room arrangements
- Keep all wall positions, lengths, and angles unchanged
- Preserve door and window placements
- Maintain room dimensions and proportions
- Keep the spatial relationships between rooms identical

PLAN TYPE: [PLAN_TYPE]
VIEW ANGLE: [VIEW_ANGLE]
STYLE: [STYLE]
QUALITY: [QUALITY]

STYLE REQUIREMENTS:
[ADDITIONAL_INSTRUCTIONS]

MATERIALS & FURNISHINGS:
- Apply appropriate flooring materials for each room type in a [PLAN_TYPE] plan
- Add furniture that respects room layouts and doorways
- Use colors and finishes that match the [STYLE] style
- Include appropriate fixtures and built-in elements
- Maintain clear circulation paths

RENDERING QUALITY:
- Photorealistic materials and textures
- Appropriate lighting to show depth and dimension
- Clear view of the floor plan layout from the [VIEW_ANGLE] angle
- Professional architectural visualization quality

FINAL CHECK:
Verify that the floor plan layout remains unchanged. Only materials, colors, and furnishings should be updated.',

        '2d_floorplan' => 'Enhance this [PLAN_TYPE] 2D floor plan drawing in [STYLE] style:

FLOORPLAN INTEGRITY:
- Maintain exact room dimensions and wall positions
- Keep all door and window placements unchanged
- Preserve the scale and proportions
- Maintain architectural symbols and annotations where present
- Keep the floor plan layout identical

PLAN TYPE: [PLAN_TYPE]
STYLE: [STYLE]
QUALITY: [QUALITY]

STYLE REQUIREMENTS:
[ADDITIONAL_INSTRUCTIONS]

GRAPHIC STYLE:
- Apply appropriate line weights and drawing conventions for [PLAN_TYPE] plans
- Add or update furniture outlines if requested
- Use clear, professional drafting standards
- Include appropriate symbols and notations
- Maintain legibility and clarity

PRESENTATION:
- Clean, professional architectural drawing quality
- Appropriate level of detail for the [PLAN_TYPE] plan type
- Clear differentiation of spaces and elements
- Easy to read and understand

FINAL CHECK:
Verify that the floor plan dimensions and layout remain accurate and unchanged. Only presentation style and graphic elements should be modified.',
    ];
}

/**
 * Get base prompt for a specific product type
 */
function getBasePrompt($product_type) {
    $prompts = getBasePrompts();

    if (isset($prompts[$product_type])) {
        return $prompts[$product_type];
    }

    // Return interior_render default if not found
    return $prompts['interior_render'];
}

/**
 * Build final prompt by substituting variables
 */
function buildFinalPrompt($product_type, $variables = []) {
    $base_prompt = getBasePrompt($product_type);

    // Default variables
    $defaults = [
        'STYLE' => '',
        'ROOM_TYPE' => '',
        'BUILDING_TYPE' => '',
        'SPACE_TYPE' => '',
        'PLAN_TYPE' => '',
        'VIEW_ANGLE' => '',
        'QUALITY' => '',
        'ADDITIONAL_INSTRUCTIONS' => '',
    ];

    // Merge with provided variables
    $vars = array_merge($defaults, $variables);

    // Replace variables in the template
    $final_prompt = $base_prompt;
    foreach ($vars as $key => $value) {
        $final_prompt = str_replace('[' . $key . ']', $value, $final_prompt);
    }

    // Clean up any remaining empty variable placeholders
    $final_prompt = preg_replace('/\[([A-Z_]+)\]/', '', $final_prompt);

    // Clean up multiple consecutive newlines
    $final_prompt = preg_replace('/\n{3,}/', "\n\n", $final_prompt);

    return trim($final_prompt);
}
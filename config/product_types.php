<?php
/**
 * Product Type Configuration
 *
 * This file defines the product types and their associated form field configurations.
 * Each product type has its own set of fields, base prompt, and validation rules.
 *
 * Product Type Mapping (prod_id to product_type):
 * - Interior Renders: p_15XX series
 * - Exterior Renders: p_17XX series
 * - Panorama Images: p_18XX series
 * - 360 Panoramas: p_19XX series
 * - 3D Floorplans: p_20XX series
 * - 2D Floorplans: p_21XX series
 */

// Product ID to Product Type Mapping
function getProductTypeFromProdId($prod_id) {
    // Remove any prefix and extract the numeric part
    $numeric_part = preg_replace('/[^0-9]/', '', $prod_id);

    if (empty($numeric_part)) {
        return 'interior_render'; // default fallback
    }

    // Convert to integer for comparison
    $prod_number = intval($numeric_part);

    // Map based on the numeric ranges
    if ($prod_number >= 1500 && $prod_number < 1600) {
        return 'interior_render';
    } elseif ($prod_number >= 1700 && $prod_number < 1800) {
        return 'exterior_render';
    } elseif ($prod_number >= 1800 && $prod_number < 1900) {
        return 'panorama_image';
    } elseif ($prod_number >= 1900 && $prod_number < 2000) {
        return '360_panorama';
    } elseif ($prod_number >= 2000 && $prod_number < 2100) {
        return '3d_floorplan';
    } elseif ($prod_number >= 2100 && $prod_number < 2200) {
        return '2d_floorplan';
    }

    // Default fallback for any other cases
    return 'interior_render';
}

// Product Type Configurations
function getProductTypeConfigs() {
    return [
        'interior_render' => [
            'name' => 'Interior Render',
            'description' => 'Interior space rendering',
            'basePromptKey' => 'interior_render',
            'fields' => [
                [
                    'id' => 'room_type',
                    'label' => 'Room Type',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        ['value' => 'living-room', 'label' => 'Living Room'],
                        ['value' => 'bedroom', 'label' => 'Bedroom'],
                        ['value' => 'kitchen', 'label' => 'Kitchen'],
                        ['value' => 'bathroom', 'label' => 'Bathroom'],
                        ['value' => 'dining-room', 'label' => 'Dining Room'],
                        ['value' => 'office', 'label' => 'Home Office'],
                        ['value' => 'hallway', 'label' => 'Hallway'],
                        ['value' => 'studio', 'label' => 'Studio'],
                        ['value' => 'gym', 'label' => 'Gym'],
                        ['value' => 'library', 'label' => 'Library'],
                    ]
                ],
                [
                    'id' => 'style_preset',
                    'label' => 'Style',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        ['value' => 'modern', 'label' => 'Modern', 'prompt' => 'Modern style with clean lines, neutral color palette, sleek furniture, and contemporary decor.', 'rooms' => 'living-room,bedroom,dining-room,office'],
                        ['value' => 'contemporary', 'label' => 'Contemporary', 'prompt' => 'Contemporary design with current trends, mixed textures, bold accents, and statement pieces.', 'rooms' => 'living-room,bedroom,dining-room,office'],
                        ['value' => 'minimalist', 'label' => 'Minimalist', 'prompt' => 'Minimalist aesthetic with uncluttered space, functional furniture, monochromatic colors, and simple decor.', 'rooms' => 'living-room,bedroom,office'],
                        ['value' => 'scandinavian', 'label' => 'Scandinavian', 'prompt' => 'Scandinavian style with light woods, white walls, cozy textiles, and natural light emphasis.', 'rooms' => 'living-room,bedroom,dining-room,office'],
                        ['value' => 'industrial', 'label' => 'Industrial', 'prompt' => 'Industrial design with exposed brick, metal fixtures, concrete elements, and vintage lighting.', 'rooms' => 'living-room,dining-room,office,kitchen'],
                        ['value' => 'mid-century', 'label' => 'Mid-Century Modern', 'prompt' => 'Mid-century modern with iconic furniture pieces, warm woods, geometric patterns, and retro colors.', 'rooms' => 'living-room,bedroom,dining-room,office'],
                        ['value' => 'bohemian', 'label' => 'Bohemian', 'prompt' => 'Bohemian style with eclectic mix, vibrant textiles, layered rugs, plants, and global-inspired decor.', 'rooms' => 'living-room,bedroom'],
                        ['value' => 'rustic', 'label' => 'Rustic', 'prompt' => 'Rustic charm with natural materials, wood beams, stone accents, and earthy color palette.', 'rooms' => 'living-room,bedroom,dining-room,kitchen'],
                        ['value' => 'farmhouse', 'label' => 'Farmhouse', 'prompt' => 'Farmhouse style with shiplap walls, vintage accessories, apron sink, and cozy country elements.', 'rooms' => 'living-room,bedroom,dining-room,kitchen'],
                        ['value' => 'traditional', 'label' => 'Traditional', 'prompt' => 'Traditional elegance with classic furniture, rich woods, ornate details, and timeless decor.', 'rooms' => 'living-room,bedroom,dining-room,office'],
                        ['value' => 'transitional', 'label' => 'Transitional', 'prompt' => 'Transitional blend of traditional and contemporary with balanced color palette and mixed materials.', 'rooms' => 'living-room,bedroom,dining-room,office'],
                        ['value' => 'coastal', 'label' => 'Coastal', 'prompt' => 'Coastal vibe with light blue tones, white furniture, nautical accents, and beachy textures.', 'rooms' => 'living-room,bedroom,bathroom'],
                        ['value' => 'mediterranean', 'label' => 'Mediterranean', 'prompt' => 'Mediterranean charm with terracotta tiles, arched doorways, warm colors, and rustic elegance.', 'rooms' => 'living-room,dining-room,kitchen,bathroom'],
                        ['value' => 'art-deco', 'label' => 'Art Deco', 'prompt' => 'Art Deco glamour with geometric patterns, luxurious materials, metallic accents, and bold colors.', 'rooms' => 'living-room,bedroom,bathroom'],
                        ['value' => 'japandi', 'label' => 'Japandi', 'prompt' => 'Japandi fusion of Japanese and Scandinavian with minimal clutter, natural materials, and zen aesthetics.', 'rooms' => 'living-room,bedroom,office'],
                        ['value' => 'eclectic', 'label' => 'Eclectic', 'prompt' => 'Eclectic mix of styles, periods, and textures with curated collections and bold personality.', 'rooms' => 'living-room,bedroom,dining-room'],
                        ['value' => 'luxury', 'label' => 'Luxury', 'prompt' => 'Luxury design with high-end finishes, plush furnishings, crystal chandeliers, and sophisticated palette.', 'rooms' => 'living-room,bedroom,bathroom,dining-room'],
                        ['value' => 'vintage', 'label' => 'Vintage', 'prompt' => 'Vintage character with antique furniture, retro appliances, aged patina, and nostalgic charm.', 'rooms' => 'living-room,bedroom,dining-room'],
                    ]
                ],
                [
                    'id' => 'quality',
                    'label' => 'Quality',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        ['value' => '1K', 'label' => '1K'],
                        ['value' => '2K', 'label' => '2K'],
                        ['value' => '4K', 'label' => '4K'],
                    ]
                ]
            ]
        ],

        'exterior_render' => [
            'name' => 'Exterior Render',
            'description' => 'Exterior architectural rendering',
            'basePromptKey' => 'exterior_render',
            'fields' => [
                [
                    'id' => 'building_type',
                    'label' => 'Building Type',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        ['value' => 'residential', 'label' => 'Residential'],
                        ['value' => 'commercial', 'label' => 'Commercial'],
                        ['value' => 'villa', 'label' => 'Villa'],
                        ['value' => 'apartment', 'label' => 'Apartment Building'],
                        ['value' => 'office', 'label' => 'Office Building'],
                        ['value' => 'mixed-use', 'label' => 'Mixed-Use'],
                    ]
                ],
                [
                    'id' => 'style_preset',
                    'label' => 'Style',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        ['value' => 'modern', 'label' => 'Modern', 'prompt' => 'Modern architectural style with clean lines, large windows, flat roofs, and minimalist materials.'],
                        ['value' => 'contemporary', 'label' => 'Contemporary', 'prompt' => 'Contemporary design with mixed materials, asymmetrical forms, and innovative features.'],
                        ['value' => 'traditional', 'label' => 'Traditional', 'prompt' => 'Traditional architecture with classic proportions, pitched roofs, and timeless materials.'],
                        ['value' => 'industrial', 'label' => 'Industrial', 'prompt' => 'Industrial aesthetic with exposed materials, metal accents, and utilitarian design.'],
                        ['value' => 'mediterranean', 'label' => 'Mediterranean', 'prompt' => 'Mediterranean style with terracotta roofs, stucco walls, and arched openings.'],
                        ['value' => 'colonial', 'label' => 'Colonial', 'prompt' => 'Colonial architecture with symmetrical facades, columns, and traditional details.'],
                    ]
                ],
                [
                    'id' => 'quality',
                    'label' => 'Quality',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        ['value' => '1K', 'label' => '1K'],
                        ['value' => '2K', 'label' => '2K'],
                        ['value' => '4K', 'label' => '4K'],
                    ]
                ]
            ]
        ],

        'panorama_image' => [
            'name' => 'Panorama Image',
            'description' => 'Wide-angle panoramic view',
            'basePromptKey' => 'panorama_image',
            'fields' => [
                [
                    'id' => 'space_type',
                    'label' => 'Space Type',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        ['value' => 'interior', 'label' => 'Interior Panorama'],
                        ['value' => 'exterior', 'label' => 'Exterior Panorama'],
                        ['value' => 'landscape', 'label' => 'Landscape Panorama'],
                    ]
                ],
                [
                    'id' => 'style_preset',
                    'label' => 'Style',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        ['value' => 'modern', 'label' => 'Modern', 'prompt' => 'Modern panoramic view with contemporary design elements and clean aesthetics.'],
                        ['value' => 'natural', 'label' => 'Natural', 'prompt' => 'Natural environment with organic elements and realistic atmosphere.'],
                        ['value' => 'urban', 'label' => 'Urban', 'prompt' => 'Urban cityscape with architectural elements and metropolitan ambiance.'],
                    ]
                ],
                [
                    'id' => 'quality',
                    'label' => 'Quality',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        ['value' => '2K', 'label' => '2K'],
                        ['value' => '4K', 'label' => '4K'],
                        ['value' => '8K', 'label' => '8K'],
                    ]
                ]
            ]
        ],

        '360_panorama' => [
            'name' => '360 Panorama',
            'description' => 'Full 360-degree panoramic image',
            'basePromptKey' => '360_panorama',
            'fields' => [
                [
                    'id' => 'space_type',
                    'label' => 'Space Type',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        ['value' => 'interior_360', 'label' => 'Interior 360'],
                        ['value' => 'exterior_360', 'label' => 'Exterior 360'],
                    ]
                ],
                [
                    'id' => 'style_preset',
                    'label' => 'Style',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        ['value' => 'modern', 'label' => 'Modern', 'prompt' => 'Modern 360-degree environment with contemporary design throughout.'],
                        ['value' => 'traditional', 'label' => 'Traditional', 'prompt' => 'Traditional 360-degree space with classic elements and timeless appeal.'],
                        ['value' => 'natural', 'label' => 'Natural', 'prompt' => 'Natural 360-degree environment with organic materials and realistic atmosphere.'],
                    ]
                ],
                [
                    'id' => 'maintain_horizon',
                    'label' => 'Maintain Horizon Line',
                    'type' => 'checkbox',
                    'required' => false,
                    'defaultValue' => true
                ],
                [
                    'id' => 'quality',
                    'label' => 'Quality',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        ['value' => '4K', 'label' => '4K'],
                        ['value' => '8K', 'label' => '8K'],
                    ]
                ]
            ]
        ],

        '3d_floorplan' => [
            'name' => '3D Floorplan',
            'description' => 'Three-dimensional floor plan visualization',
            'basePromptKey' => '3d_floorplan',
            'fields' => [
                [
                    'id' => 'plan_type',
                    'label' => 'Plan Type',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        ['value' => 'residential', 'label' => 'Residential'],
                        ['value' => 'commercial', 'label' => 'Commercial'],
                        ['value' => 'mixed-use', 'label' => 'Mixed-Use'],
                    ]
                ],
                [
                    'id' => 'view_angle',
                    'label' => 'View Angle',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        ['value' => 'top-down', 'label' => 'Top-Down'],
                        ['value' => 'isometric', 'label' => 'Isometric'],
                        ['value' => '45-degree', 'label' => '45-Degree'],
                    ]
                ],
                [
                    'id' => 'style_preset',
                    'label' => 'Style',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        ['value' => 'modern', 'label' => 'Modern', 'prompt' => 'Modern 3D floorplan with contemporary materials, colors, and furnishings.'],
                        ['value' => 'minimalist', 'label' => 'Minimalist', 'prompt' => 'Minimalist 3D floorplan with simple materials and clean presentation.'],
                        ['value' => 'realistic', 'label' => 'Realistic', 'prompt' => 'Realistic 3D floorplan with detailed materials and true-to-life rendering.'],
                    ]
                ],
                [
                    'id' => 'quality',
                    'label' => 'Quality',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        ['value' => '1K', 'label' => '1K'],
                        ['value' => '2K', 'label' => '2K'],
                        ['value' => '4K', 'label' => '4K'],
                    ]
                ]
            ]
        ],

        '2d_floorplan' => [
            'name' => '2D Floorplan',
            'description' => 'Two-dimensional floor plan drawing',
            'basePromptKey' => '2d_floorplan',
            'fields' => [
                [
                    'id' => 'plan_type',
                    'label' => 'Plan Type',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        ['value' => 'residential', 'label' => 'Residential'],
                        ['value' => 'commercial', 'label' => 'Commercial'],
                        ['value' => 'mixed-use', 'label' => 'Mixed-Use'],
                    ]
                ],
                [
                    'id' => 'style_preset',
                    'label' => 'Style',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        ['value' => 'technical', 'label' => 'Technical', 'prompt' => 'Technical 2D floorplan with precise dimensions and architectural symbols.'],
                        ['value' => 'simplified', 'label' => 'Simplified', 'prompt' => 'Simplified 2D floorplan with clean lines and easy-to-read layout.'],
                        ['value' => 'decorative', 'label' => 'Decorative', 'prompt' => 'Decorative 2D floorplan with furniture outlines and visual appeal.'],
                    ]
                ],
                [
                    'id' => 'quality',
                    'label' => 'Quality',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        ['value' => '1K', 'label' => '1K'],
                        ['value' => '2K', 'label' => '2K'],
                        ['value' => '4K', 'label' => '4K'],
                    ]
                ]
            ]
        ],
    ];
}

/**
 * Get configuration for a specific product type
 */
function getProductTypeConfig($product_type) {
    $configs = getProductTypeConfigs();

    if (isset($configs[$product_type])) {
        return $configs[$product_type];
    }

    // Return default (interior_render) if not found
    return $configs['interior_render'];
}

/**
 * Get product type from database prod_id
 */
function getProductTypeFromDatabase($prod_id) {
    return getProductTypeFromProdId($prod_id);
}
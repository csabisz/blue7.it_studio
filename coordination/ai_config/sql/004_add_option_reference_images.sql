-- Migration: Add Reference Images to Field Options
-- Version: 004
-- Date: 2026-02-06
-- Description: Adds reference_image column to ai_field_options table for style reference images

-- Add reference_image column to store image file paths
ALTER TABLE ai_field_options
ADD COLUMN reference_image VARCHAR(255) DEFAULT NULL
AFTER room_restrictions;

-- Note: Reference images are stored in /studio/coordination/ai_config/uploads/reference_images/
-- Filename format: {option_id}_{timestamp}_{random}.{ext}

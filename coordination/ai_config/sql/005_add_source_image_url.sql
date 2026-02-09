-- Migration: Add Source Image URL for URL-based Generations
-- Version: 005
-- Date: 2026-02-06
-- Description: Adds source_image_url column to o_results_ai for URL-based generations
--              and makes orf_id nullable for cases without an original file reference

-- Add source_image_url column for URL-based generations
ALTER TABLE `o_results_ai`
ADD COLUMN `source_image_url` VARCHAR(2048) NULL DEFAULT NULL
AFTER `orf_id`;

-- Make orf_id nullable for URL-based generations
ALTER TABLE `o_results_ai`
MODIFY COLUMN `orf_id` INT(11) NULL DEFAULT NULL;

-- Note: When source_image_url is populated, orf_id may be NULL
-- This allows AI generation from arbitrary image URLs (customer files, external sources)

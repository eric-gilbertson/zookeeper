<?php
/**
 * Zookeeper Online
 *
 * @author Jim Mason <jmason@ibinx.com>
 * @copyright Copyright (C) 1997-2025 Jim Mason <jmason@ibinx.com>
 * @link https://zookeeper.ibinx.com/
 * @license GPL-3.0
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License,
 * version 3, along with this program.  If not, see
 * http://www.gnu.org/licenses/
 *
 */

namespace ZK\Engine;

/**
 * Artwork operations
 */
interface IArtwork {
    function getAlbumArt($tag, $newRef = false);
    function getArtistArt($artist, $newRef = false);
    function insertAlbumArt($tag, $imageUrl, $infoUrl);
    function insertArtistArt($artist, $imageUrl, $infoUrl);
    function getCachePath($key);
    function deleteAlbumArt($tag);
    function deleteArtistArt($artist);
    function expireCache($days=10, $expireAlbums=false);
    function expireEmpty($days=1);
    /**
     * Add `image_url` and/or `info_url` properties for each album with artwork
     *
     * @param $albums target album array (in/out)
     */
    function injectAlbumArt(array &$albums): void;
}

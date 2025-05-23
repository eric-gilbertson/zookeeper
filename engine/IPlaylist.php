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
 * Playlist operations
 */
interface IPlaylist {
    /**
     * minimum show length (in minutes)
     */
    const MIN_SHOW_LEN = 15;

    /**
     * maximum show length (in minutes)
     */
    const MAX_SHOW_LEN = 6 * 60;

    /**
     * suffix appended to duplicate playlist name
     *
     * date format specifiers may be included inside %...%
     */
    const DUPLICATE_SUFFIX = " (rebroadcast from %M j, Y%)";

    /**
     * regular expression to match the name of a duplicate playlist
     *
     * should match (some substring of) DUPLICATE_SUFFIX
     */
    const DUPLICATE_REGEX = "/\Wrebroadcast\W/i";

    /**
     * comment inserted at beginning of duplicate playlist
     *
     * date format specifiers may be included inside %...%
     */
    const DUPLICATE_COMMENT =
        "Rebroadcast of an episode originally aired on %F j, Y%.";

    /**
     * internal datetime formats (do not change)
     */
    const TIME_FORMAT = "Y-m-d Hi"; // eg, 2019-01-01 1234
    const TIME_FORMAT_SQL = "Y-m-d H:i:s"; // 2019-01-01 12:34:56

    const SPECIAL_TRACK = "~~~~~~~~";
    const COMMENT_FLAG = "C";
    const LOG_FLAG = "L";

    const MAX_DESCRIPTION_LENGTH = 80;

    function getShowdates($year, $month);
    function getPlaylist($playlist, $withAirname=0);
    function getPlaylists($onlyPublished=0, $withAirname=0,
                               $showDate="", $airname="", $user="", $desc=1);
    function getPlaylistsByAirname($airname);
    function getPlaylistsByUser($user, $onlyPublished=0, $withAirname=0);
    function getPlaylistsByDate($date);
    /**
     * get playlists from previous weeks that share same weekday as target
     *
     * @param $date string date (in format yyyy-MM-dd)
     * @param $user string target user
     * @param $count int lookback limit (default 12)
     * @return array of matching playlists (empty array if no matches)
     */
    function getPlaylistsForWeekday(string $date, string $user, int $count = 12): array;
    /**
     * determine if the specified {$date, $time} is usual for the
     * specified user
     *
     * @param $date string date in yyyy-MM-dd format
     * @param $time string time range in hhmm-hhmm format
     * @param $user string target user
     * @return true if usual, false otherwise
     *
    function checkUsualSlot(string $date, string $time, string $user): bool;
    function getWhatsOnNow();
    function isNowWithinShow($listRow, $allowGrace = true);
    function insertPlaylist($user, $date, $time, $description, $airname);
    function updatePlaylist($playlist, $date, $time, $description, $airname,
                               $deleteTracksPastEnd=0);
    function duplicatePlaylist($playlist, $time = null);
    function reparentPlaylist($playlist, $user);
    function getSeq($list, $id);
    function moveTrack($list, $id, $toId, $clearTimestamp=true);
    function getTrack($id);
    function getTracks($playlist, $desc = 0);
    function getTracksWithObserver($playlist, PlaylistObserver $observer, $desc = 0, $filter = null);
    function getTimestampWindow($playlistId, $allowGrace = true);

    /**
     * hash the tracks of the specified playlist
     *
     * hash will change if count, order, or timestamps of tracks change
     *
     * @param int $playlistId target playlist
     * @return string hash value
     */
    function hashPlaylist(int $playlistId): string;

    function insertTrack($playlistId, $tag, $artist, $track, $album, $label, $spinTimestamp, &$id, &$status);
    function updateTrack($playlistId, $id, $tag, $artist, $track, $album, $label, $dateTime);
    function insertTrackEntry($playlistId, PlaylistEntry $entry, &$status);
    function updateTrackEntry($playlist, PlaylistEntry $entry);
    function deleteTrack($id);
    function getTopPlays($airname=0, $days=41, $count=10);
    function getLastPlays($tag, $count=0, $excludeAutomation=true, $excludeRebroadcasts=true);
    function getRecentPlays($airname, $count);
    function getPlaysBefore($timestamp, $limit);
    function deletePlaylist($playlist);
    function restorePlaylist($playlist);
    function purgeDeletedPlaylists($days=30);
    function getNormalPlaylistCount($user);
    function getDeletedPlaylistCount($user);
    function getListsSelNormal($user, $pos = 0, $count = 10000);
    function getListsSelDeleted($user, $pos = 0, $count = 10000);
    function isListDeleted($id);
}

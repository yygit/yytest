<?php
/**
 * Project: yytest
 * File: DbHelper.php
 * User: YY
 * Date: 18.04.2021
 */

class DbHelper
{
    private PDO $dbConnect;

    public function __construct()
    {
	    try {
		    $this->dbConnect = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . '', DB_USER, DB_PASS,
			    [PDO::ATTR_PERSISTENT => true]);
	    } catch (PDOException $e) {
		    echo __METHOD__ . ': PDO Error: ' . $e->getMessage() . '<br/>';
		    exit();
	    }
    }

    /**
     * @param string $ipAddress
     * @param string $userAgent
     * @param string $pageUrl
     *
     * @return bool
     */
    public function isUserPreviousVisit(string $ipAddress, string $userAgent, string $pageUrl): bool
    {
        $sql = "SELECT count(`id`) FROM  `" . DB_TABLE_BANNERS_LOGS . "` WHERE `user_hash` = :user_hash";

        $st = $this->dbConnect->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        $st->execute([':user_hash' => self::getUserHash($ipAddress, $userAgent, $pageUrl)]);

        return (bool)$st->fetchColumn();
    }

	/**
	 * @param string $ipAddress
	 * @param string $userAgent
	 * @param string $pageUrl
	 *
	 * @return bool
	 */
    public function insertUserDataBanners(string $ipAddress, string $userAgent, string $pageUrl): bool
    {
        $date = date('Y-m-d H:i:s');

        $sql = "INSERT INTO `" . DB_TABLE_BANNERS_LOGS . "` "
            . " (`ip_address`, `user_agent`, `page_url`, `user_hash`, `views_count`, `view_date`, `created_at`, `request`, `server`) "
            . " VALUES (:ip_address, :user_agent, :page_url, :user_hash, :views_count, :view_date, :created_at, :request, :server) ";

        $st = $this->dbConnect->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        return $st->execute([
            ':ip_address'  => $ipAddress,
            ':user_agent'  => $userAgent,
            ':page_url'    => $pageUrl,
            ':user_hash'   => self::getUserHash($ipAddress, $userAgent, $pageUrl),
            ':views_count' => 1,
            ':view_date'   => $date,
            ':created_at'  => $date,
            ':request'     => null, //serialize($_REQUEST)
            ':server'      => null, //serialize($_SERVER)
        ]);
    }

    /**
     * @param string $ipAddress
     * @param string $userAgent
     * @param string $pageUrl
     *
     * @return bool
     */
    public function updateUserDataBanners(string $ipAddress, string $userAgent, string $pageUrl): bool
    {
        $sql = "UPDATE `" . DB_TABLE_BANNERS_LOGS . "` "
            . " SET `views_count` = `views_count` + 1"
            . " WHERE `user_hash` = :user_hash";

        $st = $this->dbConnect->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

        return $st->execute([':user_hash' => self::getUserHash($ipAddress, $userAgent, $pageUrl)]);
    }

    /**
     * @param string $ipAddress
     * @param string $userAgent
     * @param string $pageUrl
     *
     * @return string
     */
    private static function getUserHash(string $ipAddress, string $userAgent, string $pageUrl): string
    {
        return md5($ipAddress . $userAgent . $pageUrl);
    }

}
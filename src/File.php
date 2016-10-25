<?php

namespace TenQuality\WP;

/**
 * File class.
 * Enables file handling functionality for Wordpress customization projects.
 * Ideal class for theme checks.
 *
 * @author Alejandro Mostajo <info@10quality.com>
 * @license MIT
 * @package Wordpress\FileSystem
 * @version 0.9.2
 */
class File
{
    /**
     * Flag that indicates whether or not file has been authenticated.
     * @since 0.9.0
     * @var bool
     */
    protected $authenticated = false;

    /**
     * Default constructor.
     * @since 0.9.0
     */
    public function __construct()
    {
        $this->authenticated = false;
    }

    /**
     * Returns self | File object with authentication process done.
     * Static constructor.
     * @since 0.9.0
     *
     * @param string $url Url to authenticate with.
     *
     * @return object this
     */
    public static function auth( $url = null )
    {
        $file = new self();
        $file->authenticate( $url );
        return $file;
    }

    /**
     * Authenticates with wordpress and validates filesystem credentials.
     * @since 0.9.0
     * @since 0.9.2 Bug fix for when functions are not loaded.
     *
     * @param string $url Url to authenticate with.
     */
    public function authenticate( $url = null )
    {
        if ( empty( $url ) )
            $url = site_url() . '/wp-admin/';
        if ( !function_exists( 'get_filesystem_method' ) )
            require_once(get_wp_home_path().'/wp-admin/includes/file.php');
        if ( get_filesystem_method() === 'direct' ) {
            $creds = request_filesystem_credentials( $url, '', false, false, array() );
            if ( ! WP_Filesystem( $creds ) ) {
                $this->authenticated = false;
            }   
            $this->authenticated = true;
        } else {
            add_action( 'admin_notice', [ &$this, 'admin_notice' ] );
        }
    }

    /**
     * Reads and checks if filename exists.
     * Returns readed file.
     * @since 0.9.0
     *
     * @global $wp_filesytem
     *
     * @param string $filename File name.
     *
     * @return string
     */
    public function read( $filename )
    {
        if (!$this->authenticated) return false;
        global $wp_filesystem;
        return $wp_filesystem->get_contents( $filename );
    }

    /**
     * Writes content in a file.
     * @since 0.9.0
     *
     * @global $wp_filesytem
     *
     * @param string $filename File name.
     * @param mixed  $content  File content.
     */
    public function write( $filename, $content )
    {
        if (!$this->authenticated) return false;
        global $wp_filesystem;
        return $wp_filesystem->put_contents(
            $filename,
            $content,
            FS_CHMOD_FILE
        );
    }

    /**
     * Returns flag indicating if path is a directory or not.
     * @since 0.9.0
     *
     * @global $wp_filesytem
     *
     * @param string $path Path to validate.
     *
     * @return bool
     */
    public function is_dir( $path )
    {
        if (!$this->authenticated) return false;
        global $wp_filesystem;
        return $wp_filesystem->is_dir( $path );
    }

    /**
     * Creates folder path.
     * @since 0.9.0
     *
     * @global $wp_filesytem
     *
     * @param string $path Path to validate.
     */
    public function mkdir( $path )
    {
        if (!$this->authenticated) return false;
        global $wp_filesystem;
        return $wp_filesystem->mkdir( $path );
    }

    /**
     * Removes folder path and contents.
     * @since 0.9.0
     *
     * @global $wp_filesytem
     */
    public function rmdir( $path )
    {
        if (!$this->authenticated) return false;
        global $wp_filesystem;
        return $wp_filesystem->rmdir( $path );
    }

    /**
     * Returns flag indicating if filename is a file.
     * @since 0.9.1
     *
     * @global $wp_filesytem
     *
     * @param string $filename File name or file path.
     *
     * @return bool
     */
    public function is_file( $filename )
    {
        if (!$this->authenticated) return false;
        global $wp_filesystem;
        return $wp_filesystem->is_file( $filename );
    }

    /**
     * Returns flag indicating if filename exists.
     * @since 0.9.1
     *
     * @global $wp_filesytem
     *
     * @param string $filename File name or file path.
     *
     * @return bool
     */
    public function exists( $filename )
    {
        if (!$this->authenticated) return false;
        global $wp_filesystem;
        return $wp_filesystem->exists( $filename );
    }

    /**
     * Displays wordpress notice.
     * @since 0.9.0
     */
    public function admin_notice()
    {
        ?>
        <div class="notice notice-success is-dismissible">
            <p>Invalid filesystem credentials.</p>
        </div>
        <?php
    }
}
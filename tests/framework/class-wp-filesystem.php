<?php
class WP_Filesystem
{
    public function __construct() {
        //todo
    }

    public function get_contents($file) {
        return @file_get_contents($file);
    }

    public function put_contents( $file, $contents, $mode = false ) {
        $fp = @fopen( $file, 'wb' );
        if ( ! $fp )
        return false;
        $data_length = strlen( $contents );
        $bytes_written = fwrite( $fp, $contents );
        fclose( $fp );
        if ( $data_length !== $bytes_written )
            return false;
        return true;
    }

    public function is_dir($path) {
        return @is_dir($path);
    }

    public function mkdir($path, $chmod = false, $chown = false, $chgrp = false) {
        if ( empty($path) )
            return false;
        if ( ! @mkdir($path) )
        return true;
    }

    public function rmdir($path) {
        return @rmdir($path);
    }

    public function is_file($filename) {
        return @is_file($filename);
    }

    public function exists($filename) {
        return @file_exists($filename);
    }
}
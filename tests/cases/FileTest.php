<?php

use TenQuality\WP\File;

/**
 * Tests File functionality.
 * @author Alejandro Mostajo <http://www.10quality.com>
 * @package Ayuco
 * @copyright MIT
 */
class FileTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests file init.
     */
    public function testConstruct()
    {
        // Prepare
        $file = File::auth();
        // Assert
        $this->assertNotNull($file);
    }
    /**
     * Tests id_dir.
     */
    public function testIsDir()
    {
        // Prepare
        $file = File::auth();
        // Assert
        $this->assertTrue(is_bool($file->is_dir(TMP_PATH)));
    }
    /**
     * Tests mkdir.
     */
    public function testMkdir()
    {
        // Prepare
        $file = File::auth();
        if (!$file->is_dir(TMP_PATH))
            $file->mkdir(TMP_PATH);
        // Assert
        $this->assertTrue($file->is_dir(TMP_PATH));
    }
    /**
     * Tests write.
     */
    public function testWrite()
    {
        // Prepare
        $success = File::auth()
            ->write(TMP_PATH.'/test.txt', 'Test result file using PHPUnit.');
        // Assert
        $this->assertTrue($success);
    }
    /**
     * Tests write.
     */
    public function testRead()
    {
        // Prepare
        $content = File::auth()->read(TMP_PATH.'/test.txt');
        // Assert
        $this->assertEquals($content, 'Test result file using PHPUnit.');
    }
    /**
     * Tests id_dir.
     */
    public function testIsFile()
    {
        // Prepare
        $file = File::auth();
        // Assert
        $this->assertTrue(is_bool($file->is_file(TMP_PATH.'/test.txt')));
    }
    /**
     * Tests id_dir.
     */
    public function testExists()
    {
        // Prepare
        $file = File::auth();
        // Assert
        $this->assertTrue(is_bool($file->exists(TMP_PATH.'/test.txt')));
    }
}
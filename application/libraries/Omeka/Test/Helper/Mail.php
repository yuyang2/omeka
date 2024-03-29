<?php
/**
 * @version $Id$
 * @copyright Roy Rosenzweig Center for History and New Media, 2007-2010
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @package Omeka
 */

/**
 * Encapsulates testing functionality for email.
 *
 * @package Omeka
 * @copyright Roy Rosenzweig Center for History and New Media, 2007-2010
 */
class Omeka_Test_Helper_Mail
{   
    /**
     * Path to the mail storage directory.
     *
     * @var string
     */
    private $_path;
    
    /**
     * @param string $path Real path to the mail storage directory.
     */
    public function __construct($path)
    {
        if (!is_dir($path)) {
            throw new RuntimeException('The mail path must be set in paths.maildir in the tests configuration.');
        }
        
        if (!is_writable($path)) {
            throw new RuntimeException('The mail path '.$path.' must be writable by this user.');
        }
        
        $this->_path = $path;
    }
    
    /**
     * Configure an instance of the Mail helper using the registered test_config.
     *
     * @return Omeka_Test_Helper_Mail
     */
    public static function factory()
    {
        $testConfig = Zend_Registry::get('test_config');
        $path = $testConfig->paths->maildir;
        $helper = new self($path);
        return $helper;
    }
    
    /**
     * Empty the fakemail storage directory between test runs.
     *
     * @return void
     */
    public function reset()
    {
        foreach ($this->_getIterator() as $file) {
            if ($this->_isMailFile($file)) {
                unlink($file->getRealPath());                
            }
        }
    }
    
    /**
     * Get an iterator over the fakemail directory.
     *
     * @return DirectoryIterator
     */
    private function _getIterator()
    {
        return new DirectoryIterator($this->_path);
    }
    
    /**
     * Check if a directory entry is a mail message file.
     *
     * @param SplFileInfo $file
     * @return boolean
     */
    private function _isMailFile(SplFileInfo $file)
    {
        return $file->isFile() && $file->isWritable(); // && $file->getFilename() != '';
    }
    
    /**
     * Return the text of the n'th email that was sent during the test.
     * 
     * Note that this will not return correct results if reset() was not 
     * invoked between test runs.
     *
     * @param integer $index
     * @return string
     */
    public function getMailText($index = 0)
    {
        $mails = array();
        foreach ($this->_getIterator() as $file) {
            if ($this->_isMailFile($file)) {
                $mails[] = $file->getRealPath();
            }
        }

        sort($mails);
        
        if (!isset($mails[$index])) {
            throw new InvalidArgumentException("No mail exists at index: $index.");
        }
        return file_get_contents($mails[$index]);
    }
}

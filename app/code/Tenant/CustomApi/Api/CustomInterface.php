<?php
namespace Tenant\CustomApi\Api;
interface CustomInterface
{
    
        /**
     * GET for Post api
     * @param string $value
     * @return string
     */
    public function getPost($value);
	
	    /**
     * GET for Post api
     * @param string $value
     * @return string
     */
	public function getAuthToken();
}
<?php

/**
 * MsgMessagesTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class MsgMessagesTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object MsgMessagesTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('MsgMessages');
    }
  
  /**
   * Get comments for a specific module and spec entry
   * @param string $module
   * @param array||int $key
   * @return array -> objects
   */
  public function getComments($module, $key) {
    // If the key isn't an array (directly the integer)
    if (!is_array($key))
      // Encaspluate the key in a array
      $key = array($key);

    switch($module) {
      case "forums":
        $column = "tid";
      break;
      case "up":
        $column = "upid";
      break;
      case "sht":
        $column = "shtid";
      break;
      case "pm":
        $column = "pmid";
      break;
      case "poll":
        $column = "pollid";
      break;
      case "news":
        $column = "nwsid";
      break;
    }

    // Execute & return the request
    return Doctrine_Query::create()
      ->select("m.*, v.*, u.username, u.avatar, u.slug, uu.username, uu.avatar, uu.slug")
      ->from("MsgMessages m")
      ->leftJoin("m.MsgVotes v")
      ->leftJoin('m.Users u')
      ->leftJoin('v.Users uu')
      ->where('m.module = ?', $module)
      ->andWhereIn('m.'.$column, $key)
      ->useQueryCache(true)->setQueryCacheLifeSpan(3600*24)  
      ->execute();
  }
}
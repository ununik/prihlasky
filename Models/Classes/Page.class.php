<?php
class Page
{
    private $_actualPID = 1;
    static private $_paths = array('');
    static private $_admin = false;
    
    static private $_pathPartNames = array(
        'page'       => 0,
        'admin_page' => 1,
        'additionalMessage' => 2,
        'language'   => 10,
    );
    
    private $_pageData;
    
    public function __construct()
    {
        if (isset($_SERVER['PATH_INFO'])) {
            Page::$_paths = explode('/', $_SERVER['PATH_INFO']);
        }
        
        if (count(Page::$_paths) > 1 && Page::$_paths[0] == '') {
            array_shift(Page::$_paths);
        }
        
        if (Page::$_paths[Page::$_pathPartNames['page']] == '') {
            $this->_pageData = Database::selectFromTable('*', 'pages', 'homepage = 1', 1);
        } else {
            if (Page::$_paths[Page::$_pathPartNames['page']] == \Conf\Paths\ADMIN_PATH) {
                Page::$_admin = true;
                if (!isset(Page::$_paths[Page::$_pathPartNames['admin_page']]) || Page::$_paths[Page::$_pathPartNames['admin_page']] == '') {
                    $this->_pageData = Database::selectFromTable('*', 'pages', 'admin_homepage = 1 ', 1);
                } else {
                    $this->_pageData = Database::selectFromTable('*', 'pages', 'admin_path = "'.Page::$_paths[Page::$_pathPartNames['admin_page']].'"', 1);
                }
            } else {
                $this->_pageData = Database::selectFromTable('*', 'pages', 'path = "'.Page::$_paths[Page::$_pathPartNames['page']].'"', 1);
            }
        }
        
        if (!isset($this->_pageData['id'])) {
            $this->_pageData = Database::selectFromTable('*', 'pages', 'page404 = 1 ', 1);
        }
        
        if (Page::$_admin && $this->_pageData['admin_log']) {
            $this->checkLoging();
            HTML::addToBodyContent('', '', HOME_DIR . \Conf\Paths\ADMIN_PANEL_VIEW);
        }
    }
    
    public function getTitle()
    {
        return $this->_pageData['title'];
    }
    
    public function getPageLink($pid, $additionalPath = '')
    {
        $path = Database::selectFromTable('admin_path, path, admin_homepage', 'pages', 'id = '. $pid, 1);
        
        if ($path['admin_path'] == '' && $path['admin_homepage'] != 1) {
            $url =  HOME_URL . '/' . $path['path'] . '/';
        } else {        
            $url =  HOME_URL . '/' .  \Conf\Paths\ADMIN_PATH . '/';
        }
        
        if ($path['admin_path'] != '') {
            $url .= $path['admin_path'] . '/';
        }
        
        if ($additionalPath != '') {
            $url .= $additionalPath . '/';
        }
        
        return $url;
    }
    
    private function checkLoging()
    {
        if (!isset($_SESSION[\Conf\Sessions\BE_USER]) || $_SESSION[\Conf\Sessions\BE_USER] == '') {
            header('Location: ' . $this->getPageLink(4));
        } else {
            User::checkId($_SESSION[\Conf\Sessions\BE_USER]);
        }
    }
    
    public function getPageViews()
    {
        $paths = Database::selectFromTable('relative_path', 'page_views', 'page = '. $this->_pageData['id'], '', 'sort', true);
        $return = array();
        foreach ($paths as $path) {
            $return[] = HOME_DIR . $path['relative_path'];
        }
        
        return $return;
    }
    
    public function getPageControllers()
    {
        $paths = Database::selectFromTable('relative_path', 'page_controllers', 'page = '. $this->_pageData['id'], '', 'sort', true);
        $return = array();
        foreach ($paths as $path) {
            $return[] .= HOME_DIR . $path['relative_path'];
        }
        
        return $return;
    }
    
    public function getNavigation()
    {
        $parentNavParts = Database::selectFromTable('*', 'page_navigation', 'navigation = '. $this->_pageData['navigation'] . ' AND parent = 0', '', 'sort', true);
        $return = '';
        
        if (count($parentNavParts) > 0) {
            $return .= '<ul class="navigation">';
            foreach ($parentNavParts as $nav) {
                $return .= '<li><a href="'.$this->getPageLink($nav['pid']).'">'.$nav['title'].'</a>';
                $return .= $this->getSubnavigation($nav['id']);
                $return .= '</li>';
            }
            $return .= '</ul>';
        }
        
        return $return;
    }
    
    public function getSubnavigation($id)
    {
        $parentNavParts = Database::selectFromTable('*', 'page_navigation', 'navigation = '. $this->_pageData['navigation'] . ' AND parent = ' . $id, '', 'sort', true);
        $return = '';
        
        if (count($parentNavParts) > 0) {
            $return .= '<ul class="navigation">';
            foreach ($parentNavParts as $nav) {
                $return .= '<li><a href="'.$this->getPageLink($nav['pid']).'">'.$nav['title'].'</a>';
                $return .= $this->getSubnavigation($nav['id']);
                $return .= '</li>';
            }
            $return .= '</ul>';
        }
        
        return $return;
    }
    
    public function getAdditionalMessage()
    {
        if (Page::$_admin) {
            return Page::$_paths[Page::$_pathPartNames['additionalMessage']];
        }
        
        return Page::$_paths[Page::$_pathPartNames['additionalMessage'] - 1];
    }
}
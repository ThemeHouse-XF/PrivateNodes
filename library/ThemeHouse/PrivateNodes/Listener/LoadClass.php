<?php

class ThemeHouse_PrivateNodes_Listener_LoadClass extends ThemeHouse_Listener_LoadClass
{

    protected function _getExtendedClasses()
    {
        return array(
            'ThemeHouse_PrivateNodes' => array(
                'controller' => array(
                    'XenForo_ControllerAdmin_Node',
                    'XenForo_ControllerAdmin_Permission_Node'
                ), /* END 'controller' */
            ), /* END 'ThemeHouse_PrivateNodes' */
        );
    } /* END _getExtendedClasses */

    public static function loadClassController($class, array &$extend)
    {
        $loadClassController = new ThemeHouse_PrivateNodes_Listener_LoadClass($class, $extend, 'controller');
        $extend = $loadClassController->run();
    } /* END loadClassController */
}
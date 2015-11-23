<?php

/**
 *
 * @see XenForo_ControllerAdmin_Node
 */
class ThemeHouse_PrivateNodes_Extend_XenForo_ControllerAdmin_Node extends XFCP_ThemeHouse_PrivateNodes_Extend_XenForo_ControllerAdmin_Node
{

    public function actionPrivate()
    {
        $nodeModel = $this->_getNodeModel();

        $nodes = $nodeModel->prepareNodesForAdmin($nodeModel->getAllNodes());

        $permissionEntries = $this->_getPermissionModel()->getAllContentPermissionEntriesByTypeGrouped('node');
        $privateNodes = array();
        foreach ($permissionEntries['system'] as $nodeId => $nodePermissions) {
            if (!empty($nodePermissions['general']['viewNode']) && $nodePermissions['general']['viewNode'] == 'reset') {
                $privateNodes[$nodeId] = true;
            }
        }

        $permissionSets = $this->_getPermissionModel()->getUserCombinationsWithContentPermissions('node');
        $nodesWithPerms = array();
        foreach ($permissionSets as $set) {
            $nodesWithPerms[$set['content_id']] = true;
        }

        $viewParams = array(
            'nodes' => $nodes,
            'nodesWithPerms' => $nodesWithPerms,
            'privateNodes' => $privateNodes
        );

        return $this->responseView('ThemeHouse_PrivateNodes_ViewAdmin_Node_List', 'th_node_list_privatenodes',
            $viewParams);
    } /* END actionPrivate */
}
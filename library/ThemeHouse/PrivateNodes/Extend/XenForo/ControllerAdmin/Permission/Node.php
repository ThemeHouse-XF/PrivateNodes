<?php

/**
 *
 * @see XenForo_ControllerAdmin_Permission_Node
 */
class ThemeHouse_PrivateNodes_Extend_XenForo_ControllerAdmin_Permission_Node extends XFCP_ThemeHouse_PrivateNodes_Extend_XenForo_ControllerAdmin_Permission_Node
{

    public function actionTogglePrivate()
    {
        $this->_assertPostOnly();

        $idExists = $this->_input->filterSingle('exists',
            array(
                XenForo_Input::UINT,
                'array' => true
            ));
        $ids = $this->_input->filterSingle('id',
            array(
                XenForo_Input::UINT,
                'array' => true
            ));

        $nodeModel = $this->_getNodeModel();

        $nodes = $nodeModel->getAllNodes();

        $permissionEntries = $this->_getPermissionModel()->getAllContentPermissionEntriesByTypeGrouped('node');
        $privateNodes = array();
        foreach ($permissionEntries['system'] as $nodeId => $nodePermissions) {
            if (!empty($nodePermissions['general']['viewNode']) && $nodePermissions['general']['viewNode'] == 'reset') {
                $privateNodes[$nodeId] = true;
            }
        }

        foreach ($nodes as $nodeId => $node) {
            if (isset($idExists[$nodeId])) {
                $itemActive = (!empty($ids[$nodeId]) ? 1 : 0);

                if (!empty($privateNodes[$nodeId]) != $itemActive) {
                    // TODO: better approach that doesn't rely on every
                    // permission having "revoke" value
                    $this->_setPermissionRevokeStatus($node['node_id'], 0, 0, $itemActive);
                }
            }
        }

        return $this->responseRedirect(XenForo_ControllerResponse_Redirect::SUCCESS,
            XenForo_Link::buildAdminLink('nodes/private', $node));
    } /* END actionTogglePrivate */
}
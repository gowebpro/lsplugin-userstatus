<?php
/*-------------------------------------------------------
*
*   Plugin name:    Userstatus
*   Author:         Chiffa
*   Web:            http://goweb.pro
*
---------------------------------------------------------
*/

/**
 * Регистрация хуков
 *
 */
class PluginUserstatus_HookUser extends Hook
{

    public function RegisterHook()
    {
        $this->AddHook('template_profile_top_end', 'tplProfileTopBegin');
        $this->AddHook('template_stream_list_event_update_status', 'StreamEventUpdateStatus');
    }

    public function tplProfileTopBegin($aParams = array())
    {
        $oUserProfile = isset($aParams['oUserProfile']) ? $aParams['oUserProfile'] : null;
        $oUserCurrent = $this->User_GetUserCurrent();
        if ($oUserProfile) {
            $oUserStatus = $this->PluginUserstatus_User_GetStatusByUserId($oUserProfile->getId());
            $this->Viewer_Assign('oUserProfile', $oUserProfile);
            $this->Viewer_Assign('oUserCurrent', $oUserCurrent);
            $this->Viewer_Assign('oUserStatus', $oUserStatus);
            return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__) . 'inject.header_top.tpl');
        }
    }

    public function StreamEventUpdateStatus($aParams=array()) {
        if (isset($aParams['oStreamEvent'])) {
            $this->Viewer_Assign('oStreamEvent', $aParams['oStreamEvent']);
            return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__) . 'event.update_status.tpl');
        }
    }

}

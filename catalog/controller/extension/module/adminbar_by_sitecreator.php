<?php
if (!class_exists('ControllerExtensionModuleAdminbarBySitecreator')) {
  class ControllerExtensionModuleAdminbarBySitecreator extends Controller {
    public function index() {
      $html = $this->controller_module_admin_by_sitecreator->index();
      return $html;
    }
  }
}
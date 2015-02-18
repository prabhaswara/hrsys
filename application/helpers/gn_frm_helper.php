<?php

if (!function_exists('showMessage')) {

    function showMessage($messages, $type = "error", $id = "") {//error success warning notice
        $print_msg = "";
        $showBox = false;
        if (is_array($messages)) {

            if (is_array($messages) && count($messages) > 1) {

                $print_msg = "<ul>";
                foreach ($messages as $message) {
                    $print_msg.="<li>$message</li>";
                }
                $print_msg.="</ul>";
            }

            if (is_array($messages) && count($messages) == 1) {

                $print_msg = current($messages);
            }

            if ($print_msg != "" && !empty($print_msg)) {
                $showBox = true;
            }
        } else if ($messages != "") {
            $showBox = true;
            $print_msg = $messages;
        }
        $box = $showBox ? "<div id='alert-box$id' class='alert-box $type'><span>$type: </span> <img src='".  base_url()."images/delete.png' class='close_box' id='close_box$id' /> <div>$print_msg </div>  </div><script>$(function () {  $('#close_box$id').click(function () { $('#alert-box$id').hide(); }); }); </script>" : "";

        return $box;
    }

}


if (!function_exists('breadcrumb_')) {
   
    function breadcrumb_($items){
        $return="";
        if(!empty($items)){
            $return.="<div class='gn_breadcrumb'>";
            foreach($items as $key=>$item){
                $return.="<a href='".$item["link"]."'>".$item["text"]."</a>";
                
                if(isset($items[$key+1]))
                    $return.=" <span class='fa-arrow-right'>&nbsp;<span>";
            }
            
            $return.="</div>";
        }
        return $return;
    }
    
}

if (!function_exists('frm_')) {

    function frm_($name = '', $dataForm = array(), $extra = '') {
        $type = "type='text'";
        if (strpos(strtolower($extra), "type")) {
            $type = "";
        }
        $value = "";

        if (isset($dataForm[$name])) {
            $value = $dataForm[$name];
        }


        return "<input name='frm[$name]' id='$name' value='$value' $extra />";
    }

}
if (!function_exists('textarea_')) {

    function textarea_($name = '', $dataForm = array(), $extra = '') {
        $type = "type='text'";
        if (strpos(strtolower($extra), "type")) {
            $type = "";
        }
        $value = "";

        if (isset($dataForm[$name])) {
            $value = $dataForm[$name];
        }

        return "<textarea name='frm[$name]' id='$name' $extra >$value</textarea>";
    }

}
if (!function_exists('select_')) {

    function select_($name = '', $dataForm = array(), $options = array(), $extra = '', $pilih = true) {
   
        $type = "type='text'";
        if (strpos(strtolower($extra), "type")) {
            $type = "";
        }
        $value = "";

        if (isset($dataForm[$name])) {
            $value = $dataForm[$name];
        }
     

        $return = "<select name='frm[$name]' id='$name' $extra >";
        if ($pilih)
            $return.="<option value=''>--choose--</option>";

        if (!empty($options))
            foreach ($options as $optVal => $optName) {
            
                $selected = (trim($optVal) === trim($value)) ? "selected='selected'" : "";
                $return.=
                        "<option value='$optVal' $selected >$optName</option>";
            }

        $return.="</select>";
        return $return;
    }

    
    if (!function_exists('frm_g')) {

        function frm_g($group,$name = '', $dataForm = array(), $extra = '') {
            $type = "type='text'";
            if (strpos(strtolower($extra), "type")) {
                $type = "";
            }
            $value = "";

            if (isset($dataForm[$name])) {
                $value = $dataForm[$name];
            }


            return "<input name='".$group."[$name]' id='".$group."_$name' value='$value' $extra />";
        }

    }
    if (!function_exists('textarea_g')) {

        function textarea_g($group,$name = '', $dataForm = array(), $extra = '') {
            $type = "type='text'";
            if (strpos(strtolower($extra), "type")) {
                $type = "";
            }
            $value = "";

            if (isset($dataForm[$name])) {
                $value = $dataForm[$name];
            }

            return "<textarea name='".$group."[$name]' id='".$group."_$name' $extra >$value</textarea>";
        }

    }
    if (!function_exists('select_g')) {

        function select_g($group,$name = '', $dataForm = array(), $options = array(), $extra = '', $pilih = true) {

            $type = "type='text'";
            if (strpos(strtolower($extra), "type")) {
                $type = "";
            }
            $value = "";

            if (isset($dataForm[$name])) {
                $value = $dataForm[$name];
            }


            $return = "<select name='".$group."[$name]' id='".$group."_$name' $extra >";
            if ($pilih)
                $return.="<option value=''>--choose--</option>";

            if (!empty($options))
                foreach ($options as $optVal => $optName) {

                    $selected = (trim($optVal) === trim($value)) ? "selected='selected'" : "";
                    $return.=
                            "<option value='$optVal' $selected >$optName</option>";
                }

            $return.="</select>";
            return $return;
        }

    }


}
?>
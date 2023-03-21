<?php

//checks if id's exists
function isValid($id, $model){
    $model->id = $id;

    if($model->read_single()){
        return true;
    }else{
        return false;
    }
}

?>
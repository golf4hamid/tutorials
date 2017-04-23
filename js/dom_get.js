function _i(id){
    var res = document.getElementById(id);
    if(res){
        return res;
    }
    return false;
}

//

function _t(tag){
    var res = document.getElementsByTagName(tag);
    if(res){
        return res;
    }
    return false;
}

//

function _c(cls){
    var res = document.getElementsByClassName(cls);
    if(res){
        return res;
    }
    return false;
}
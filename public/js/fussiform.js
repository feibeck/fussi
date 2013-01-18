var FussiForm = function() {
    this.connectFields = function(field1, field2) {
        $('#'+field1).blur(function(){
            if($('#'+field1).val()<=0){
                $('#'+field1).val(0);
                $('#'+field2).val(10);
            } else if($('#'+field1).val()>10){
                $('#'+field1).val(10);
            } else if($('#'+field1).val()!=10){
                $('#'+field2).val(10);
            }
        });
        $('#'+field2).blur(function(){
            if($('#'+field2).val()<=0){
                $('#'+field2).val(0);
                $('#'+field1).val(10);
            } else if($('#'+field2).val()>10){
                $('#'+field2).val(10);
            } else if($('#'+field2).val()!=10){
                $('#'+field1).val(10);
            }
        });
    }
}
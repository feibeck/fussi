var FussiForm = function() {
    this.connectFields = function(field1, field2) {
        f1 = $('#'+field1);
        f2 = $('#'+field2);
        // fill the field opposite to the field that has less than 10 goals
        this.blurFillField(f1,f2);
        this.blurFillField(f2,f1);

        // let the user increase/decrease fields, set 10 onFocus if empty
        this.focusFillField(f1,f2);
        this.focusFillField(f2,f1);
        this.adornField(f1);
        this.adornField(f2);
    }

    this.focusFillField = function(current, other) {
        current.focus(function(){
            var o = other.val();
            if (current.val()==='' && o !== '' && o != 10 ) {
                current.val(10);
            }
        });
    }

    this.blurFillField = function(current, other) {
        current.blur(function(){
            if(current.val()<=0){
                current.val(0);
                other.val(10);
            } else if(current.val()>10){
                current.val(10);
            } else if(current.val()!=10){
                other.val(10);
            }
        });

    }

    this.adornField = function(element) {
        var inc = 'inc' + element.attr('id');
        var dec = 'dec' + element.attr('id');
        element.addClass('span2')
            .wrap('<div class="input-prepend input-append">')
            .after('<a class="btn" id="'+inc+'"><i class="icon-arrow-right"></i></a>')
            .before('<a class="btn" id="'+dec+'"><i class="icon-arrow-left"></i></a>')
        element.next().click(function(){
            if (element.val()<10) {
                element.val(element.val() - 0 + 1);
            }
        });
        element.prev().click(function(){
            if (element.val()>0) {
                element.val(element.val() - 1);
            }
        });
    }

}
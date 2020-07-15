

(function() {

    var new_session=`<div class="event-session">
                        <div class="collapsible">
                            <input type="text" class="editable" name="sessname[]" contenteditable placeholder="Enter Session Name" required>
                            <i class="fa fa-caret-down" aria-hidden="true"></i>
                            <i class="fa fa-caret-up" aria-hidden="true"></i>
                            <i class="far fa-trash-alt"></i>
                        </div>
                        <div class="session-content">
                            <textarea type="text" name="sessdesc[]" placeholder="enter session info" class="session-info" required></textarea>
                        </div>
                    </div>`   
                    
    //Toggle side bar button
    $(".mobile-toggle").on('click', function(){
        $(this).toggleClass("mobile-toggle-active")
        $("nav").toggleClass("nav-active");
        $(".top-menu").toggleClass("top-menu-active")
        $(".content").toggleClass("content-active");
        $(".create,.delete").toggleClass("button-active");
        $("i.fa-plus, i.fa-minus").toggleClass("icon-active");
    })

    //Event listener that listens to dynamically addded sessions
    $(document).delegate('.fa-caret-down,.fa-caret-up', 'click', function(){
        //console.log(e.keyCode);
        var collapse=$(this).parent();
        collapse.toggleClass("active");
        var content=collapse.next();
        var fa_up=collapse.find(".fa-caret-up");
        var fa_down=collapse.find(".fa-caret-down");

        if(content.css("max-height")=="0px"){
            content.css("max-height", content.prop("scrollHeight")+"px");
            fa_up.css("display", "block");
            fa_down.css("display", "none");
        }
        else {
            content.css("max-height", "0px");
            fa_up.css("display", "none");
            fa_down.css("display", "block");
        }
   });



   //Event listener that listens to dynamically added sessions
   $(document).delegate('.fa-trash-alt','click', function () {
       //console.log("trash");
       var session=$(this).parent().parent();
       session.remove();

       //traverse and update number
       var number=1;
       //console.log("deleting");
       $('.event-session').each(function(){
        //console.log(number);
        $(this).attr('id', 'session'+number);
        number++;
        
    });

       
   });

   //Add session event handler
   $(document).on('click', '.add-session', function(){
       
    var pre_session=$('.add-session').prev();
    //console.log(pre_session);
    pre_session.after(new_session);
    //traverse and assign number
    //console.log("adding");
    var number=1;
    $('.event-session').each(function(){
        //console.log(number);
        $(this).attr('id', 'session'+number);
        number++;
        
    });
   })
   
})();

// sets minimum date for date inputs.
var todaydate = new Date().toISOString().split('T')[0];
document.getElementById("date1").setAttribute('min', todaydate);
document.getElementById("date2").setAttribute('min', todaydate);

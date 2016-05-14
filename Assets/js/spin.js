var $div = $( '.wrappper ');
    var $div2= $('.follower2');
    var $div3= $('.follower3');
    var $div4= $('.follower4');
    var $div5= $('.follower5');
    var $div6= $('.follower6');
    var $div7= $('.follower7');

var positioned=1;
$( document ).bind( 'mousemove', function( ev ){
            $div.css( { left : ev.pageX-20, top : ev.pageY -75} );
            if(positioned==1) {
                positioned = 0;
                setInterval(function(){
                    var d2=$('.follower').position();
                    var d3=$('.follower2').position();
                    var d4=$('.follower3').position();
                    var d5=$('.follower4').position();
                    var d6=$('.follower5').position();
                    var d7=$('.follower6').position();
                    $div2.css({left : d2.left-10, top : d2.top-10});
                    $div3.css({left : d3.left - 20, top : d3.top - 20});
                    $div4.css({left : d4.left - 20, top : d4.top - 20});
                    $div5.css({left : d5.left - 20, top : d5.top - 20});
                    $div6.css({left : d6.left - 20, top : d6.top - 20});
                    $div7.css({left : d7.left - 20, top : d7.top - 20});
                },1);
            }
});

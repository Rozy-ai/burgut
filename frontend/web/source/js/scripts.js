$(function() {
    var path = location.pathname;
    $("a[href='" + path + "']").addClass('active');
});

$( '#header_info' ).hover(
  function() {
     $("#header_info ul" ).addClass( "show" );
  }, function() {
    $("#header_info ul" ).removeClass( "show" );
  }
);


$( '.img_block_cart_category' ).hover(
  function() {
     $( this ).addClass( "hvr" );
  }, function() {
    $( this ).removeClass( "hvr" );
  }
);

// $( '.hvr' ).hover(
//   function() {
//     $( 'hvr img.hover_image' ).css({
//       'z-index' : '2'
//     });
//   }, function() {
//     $( '.hvr img.hover_image' ).css({
//       'z-index' : '-1'
//     });
//   }
// );

    //     $('#show').click(function(){
    //   $(this).css('display','none');
    //   $('#hide').css({
    //     'display':'block',
    //   });
    //   $('.search').show(400).css('display','block');
    //   $('.search_submit').show(400).css('display','block');
    // });
    // $('#hide').click(function(){
    //   $(this).css('display','none');
    //   $('#show').css({
    //     'display':'block',
    //   });
    //   $('.search').hide(400);
    //   $('.search_submit').hide(400);
    // });

      $(".regular").slick({
        dots: true,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        prevArrow: '<div class="slick_prev_bottom"><span class="line_slick"></span><i class="fa fa-angle-left"></i></div>',
        nextArrow: '<div class="slick_next_bottom"><span class="line_slick"></span><i class="fa fa-angle-right"></i></div>',
          responsive: [
      {
        breakpoint: 550,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
      });

        $(".regular_2").slick({
          prevArrow: '<div class="slick_prev_bottom"><i class="fa fa-angle-left"></i></div>',
        nextArrow: '<div class="slick_next_bottom"><i class="fa fa-angle-right"></i></div>',
    dots: false,
    infinite: true,
    slidesToShow: 4,
    slidesToScroll: 1,
    responsive: [
      {
        breakpoint: 550,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 750,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 950,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1
        }
      },
    ]
  });

      $(".regular_tab").slick({
        dots: false,
        lazyLoad: 'ondemand',
        fade: false,
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        prevArrow: '<div class="slick_prev"><i class="fa  fa-angle-left"></i></div>',
        nextArrow: '<div class="slick_next"> <i class="fa  fa-angle-right"></i> </div>',
          responsive: [
      {
        breakpoint: 750,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 550,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      },
    ]
      });

// $(".regular_tab_2").slick({
//         dots: false,
//         lazyLoad: 'ondemand',
//         fade: false,
//         infinite: true,
//         // fade: false,
//         slidesToShow: 4,
//         slidesToScroll: 1,
//         prevArrow: '<div class="slick_prev"><i class="fa  fa-angle-left"></i></div>',
//         nextArrow: '<div class="slick_next"> <i class="fa  fa-angle-right"></i> </div>',
//           responsive: [
//       {
//         breakpoint: 750,
//         settings: {
//           slidesToShow: 2,
//           slidesToScroll: 1
//         }
//       },
//       {
//         breakpoint: 550,
//         settings: {
//           slidesToShow: 1,
//           slidesToScroll: 1
//         }
//       },
//     ]
//       });

   
 // $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
 //     e.target
 //     e.relatedTarget
 //     $('.regular_tab_2').slick('reinit');
 // });

    $(".center").slick({
    cssEase: 'linear',
    autoplay: true,
    autoplaySpeed: 0,
    speed: 9000,
    arrows: false,
    draggable: true,
    pauseOnHover: true,
    dots: false,
    infinite: true,
    centerMode: true,
    slidesToShow: 6,
    slidesToScroll: 1,
            responsive: [
      {
        breakpoint: 576,
        settings: {
          slidesToShow: 2,
        }
      },
      // {
      //   breakpoint: 750,
      //   settings: {
      //     slidesToShow: 3,
      //   }
      // },
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 3,
        }
      },
      {
        breakpoint: 1400,
        settings: {
          slidesToShow: 4,
        }
      },
    ]
  });

//       $(".like-Unlike").click(function(e) {
//         // var a = $(this).html();
//         // alert(a);
//     if ($(this).html() == '<i class="fa fa-heart-o"></i>') {
//         $(this).html('<i class="fa fa-heart" style="color : red"></i>');
//     }
//     else {
//         $(this).html('<i class="fa fa-heart-o"></i>');
//     }
//     return false;
// });


      $('.like-Unlike').on('click', function (e) {
  e.preventDefault();
  var self = $(this);  
  $.ajax({
    url: $(this).attr('href'),
    type: 'GET',
    success: function(){
      // alert(1);
      // var a = $(this).html();
      self.html('<i class="fa fa-heart " style="color : red"></i>');
      // self.addClass('redheart').removeClass('like-Unlike');
    },
    error: function () {
      alert('Error!');
    }
  });
});



//       var myModal = document.getElementById('myModal')
// var myInput = document.getElementById('myInput')

// myModal.addEventListener('shown.bs.modal', function () {
//   myInput.focus()
// });

$('#cart .modal-body').on('click', '.del-item', function(){
  var id = $(this).data('id');
    $.ajax({
    url: '/cart/del-item',
    data: {id: id},
    type: 'GET',
    success: function(res){
      if(!res) alert('Error');
      showCart(res);
    },
    error: function () {
      alert('Error!');
    }
  });
});

function clearCart(){
  $.ajax({
    url: '/cart/a/clear',
    type: 'GET',
    success: function(res){
      if(!res) alert('Error');
      showCart(res);
    },
    error: function () {
      alert('Error!');
    }
  });
}

function getCart(){
  $.ajax({
    url: '/cart/show',
    type: 'GET',
    success: function(res){
      if(!res) alert('Error');
      showCart(res);
    },
    error: function () {
      alert('Error!');
    }
  });
  return false;
}

function showCart(cart){
$('#cart .modal-body').html(cart);
$('#cart').modal();
}


$('.add-to-cart').on('click', function (e) {
  e.preventDefault();
  var id = $(this).data('id'), 
  qty = $('#qty').val(); 
  $.ajax({
    url: '/cart/a/add',
    data: {id: id, qty: qty},
    type: 'GET',
    success: function(res){
      if(!res) alert('Error');
      showCart(res);
    },
    error: function () {
      alert('Error!');
    }
  });
});

$('#basket').on('click', function (e) {
  e.preventDefault();
    $.ajax({
    url: '/cart/a/show',
    type: 'GET',
    success: function(res){
      if(!res) alert('Error');
      showCart(res);
    },
    error: function () {
      alert('Error!');
    }
  });
});



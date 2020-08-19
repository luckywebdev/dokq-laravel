$(document).ready(function(){
  handleSpinners();
})
var bootboxNotification = function(message){
	bootbox.dialog({
        message: message,
        title: "読Q",
        closeButton:false,
        buttons: {
          success: {
            label: "確認",
            className: "blue",
            callback: function() {
              return;
            }
          }
     	}
    });
}

var handleSpinners = function () {
    $('#member_counts').spinner({min: 0});
    $('#year').spinner({min: 0});
}


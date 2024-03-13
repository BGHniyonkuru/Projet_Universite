$(document).ready(function() {
    $('#compare-button').click(function(){
        $.ajax({
            url:'http://localhost:8501/comparison-universities';
            success: function(data){
                window.location.href = data;
            },
            error: function(xhr, status, error){
                console.error(status, error);
            }
        });
    });
});
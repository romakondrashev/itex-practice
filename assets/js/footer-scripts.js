$('#add_queue_form').on('submit', function(e){
    e.preventDefault();
    let $this = $(this);
    
    $.ajax({
        type: 'POST',
        url: 'backend/add-queue.php',
        data: $(this).serialize(),
        beforeSend: function(e){
            $this.find('[type="submit"]').attr('disabled','disabled').val('Отправка данных...');
        },
        success: function (error){
            if (error === '0') {
                $this.slideUp(function () {
                    $this.html('<p class="text-success">Данные успешно сохранены!</p>').slideDown();
                    websocket_callback('add_queue', $('body').data('queue-id'));
                    setTimeout(()=>location.reload(),2000);
                });
            } else if (error === '1') {
                $this.find('#messages').html('<div class="alert alert-danger" role="alert">Пожалуйста, заполните все необходимые поля</div>');
            }
            $this.find('[type="submit"]').removeAttr('disabled').val('Сохранить');
            
        }
    })

})

function clicked_new_queue_button(e){
    $('#add_queue_form').trigger('reset');
    $('#add_queue_modal h2').text('Добавление очереди');
    $('#add_queue_modal [name="queue_id"]').val(0);
}

function edit_user_click(user_id, user_name) {
    $('#edit_user_modal h2').text(user_name);
    $('#edit_user_modal [name="user_id"]').val(user_id);
}



$('#edit_user_form').on('submit', function(e){
    e.preventDefault();

    let $this = $(this);

    $.ajax({
        type: 'POST',
        url: 'backend/queue-users/change-user-status-by-author.php',
        data: $(this).serialize(),
        dataType: 'json',
        beforeSend: function(e){
            $this.find('[type="submit"]').attr('disabled','disabled').val('Отправка данных...');
        },
        success: function (info){

            $this.find('[type="submit"]').removeAttr('disabled').val('Сохранить');

            $('#edit_user_modal').find('[data-fancybox-close]').trigger('click');
            $this.trigger('reset');
            if(info.data === '')
                websocket_callback('get_queue_users', $('body').data('queue-id'));
            else
                websocket_callback('get_queue_users', $('body').data('queue-id'), info.data.join(','));

        }
    })
})



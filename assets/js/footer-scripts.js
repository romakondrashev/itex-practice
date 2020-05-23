$('#add_queue_form').on('submit', function(e){
    e.preventDefault();
    
    $.ajax({
        type: 'POST',
        url: 'backend/add-queue.php',
        data: $(this).serialize(),
        beforeSend: function(e){
            $('#add_queue_form [type="submit"]').attr('disabled','disabled').val('Отправка данных...');
        },
        success: function (error){
            if (error === '0') {
                $('#add_queue_form').slideUp(function () {
                    $('#add_queue_form').html('<p class="text-success">Данные успешно сохранены!</p>').slideDown();
                    setTimeout(()=>location.reload(),2000);
                });
            } else if (error === '1') {
                $('#messages').html('<div class="alert alert-danger" role="alert">Пожалуйста, заполните все необходимые поля</div>');
            }
            $('#add_queue_form [type="submit"]').removeAttr('disabled').val('Сохранить');
        }
    })

})

function clicked_new_queue_button(e){
    $('#add_queue_form').trigger('reset');
    $('#add_queue_modal h2').text('Добавление очереди');
    $('#add_queue_modal [name="queue_id"]').val(0);
}


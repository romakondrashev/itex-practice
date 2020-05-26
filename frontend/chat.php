<?php require '../connection.php'; ?>
<div class="floating-chat" >
    <i class="fa fa-comments" aria-hidden="true"></i>
    <div class="chat">
        <div class="header">
            <span class="title">
                Чат участников очереди
            </span>
            <button>
                <i class="fa fa-times" aria-hidden="true"></i>
            </button>

        </div>
        <ul class="messages">
            <!-- Messages -->
        </ul>
        <div class="footer">
            <div class="text-box" contenteditable="true" disabled="true"></div>
            <button id="sendMessage">Отправить</button>
        </div>
    </div>
</div>
<script src="<?php echo $home_url; ?>/assets/js/chat.js"></script>


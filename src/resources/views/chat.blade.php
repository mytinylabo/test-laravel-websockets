<html>
<head>
<meta name="csrf-token" content="{{ csrf_token() }}"><!-- 必要か不明 -->
</head>
<body>
    <div id='app'></div><!-- 必要か不明 -->
    <div id="chat">
        <textarea v-model="message"></textarea>
        <br>
        <button type="button" @click="send()">送信</button>

        <div v-for="m in messages">
            <!-- 登録された日時 -->
            <span v-text="m.created_at"></span>：&nbsp;

            <!-- メッセージ内容 -->
            <span v-text="m.body"></span>
        </div>
    </div>
    <script src="/js/app.js"></script>
    <script>

        new Vue({
            el: '#chat',
            data: {
                message: '',
                messages: []
            },

            methods: {
                getMessages() {
                    const url = '/ajax/chat';
                    axios.get(url)
                        .then((response) => {
                            this.messages = response.data;
                        });
                },

                send() {
                    const url = '/ajax/chat';
                    const params = { message: this.message };
                    axios.post(url, params)
                        .then((response) => {
                            // 成功したらメッセージをクリア
                            this.message = '';
                        });
                }
            },

            mounted() {
                this.getMessages();

                Echo.channel('chat')
                    .listen('MessageCreated', (e) => {
                        this.getMessages(); // 全メッセージを再読込
                    });
            }

        });

    </script>
</body>
</html>

<script>
    export default {
        name: "Answer",
        props: ['answer'],
        data() {
            return {
                editing: false,
                body: this.answer.body,
                bodyHtml: this.answer.body_html,
                id: this.answer.id,
                questionId: this.answer.question_id,
                beforeEditCache: null,
            }
        },

        computed: {
            isInvalid() {
                console.log(this.body.length);
                return this.body.length < 10;
            },
            endpoint() {
                return `/questions/${this.questionId}/answers/${this.id}`;
            }
        },

        methods: {
            edit() {
                this.beforeEditCache = this.body;
                this.editing = true;
            },

            cancel() {
                this.body = this.beforeEditCache;
                this.editing = false;
            },

            updateAnswer() {
                axios.patch(this.endpoint, {
                    body: this.body
                }).then(
                    res => {
                        console.log('res', res);
                        this.editing = false;
                        this.bodyHtml = res.data.body_html
                        this.$toast.success(res.data.message, "Success", {timeout: 3000});
                    }
                ).catch(err => {
                    this.$toast.error(err.response.data.message, "Error", {timeout: 3000});
                });
            },

            deleteAnswer() {
                this.$toast.question('Are you sure?', 'confirm', {
                    timeout: 20000,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 999,
                    title: 'Hey',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', (instance, toast) => {

                            axios.delete(this.endpoint)
                                .then(
                                    res => {
                                        $(this.$el).fadeOut(500, () => {
                                            this.$toast.success(res.data.message, "Success", {timeout: 3000});
                                        })
                                    }
                                )
                                .catch(err => {
                                    this.$toast.error(err.response.data.message, "Error", {timeout: 3000});
                                })

                            instance.hide({transitionOut: 'fadeOut'}, toast, 'button');

                        }, true],
                        ['<button>NO</button>', function (instance, toast) {

                            instance.hide({transitionOut: 'fadeOut'}, toast, 'button');

                        }],
                    ],
                    onClosing: function (instance, toast, closedBy) {
                        console.info('Closing | closedBy: ' + closedBy);
                    },
                    onClosed: function (instance, toast, closedBy) {
                        console.info('Closed | closedBy: ' + closedBy);
                    }
                });
            }
        }
    }
</script>
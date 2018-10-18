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
            isInvalid () {
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
                    }
                ).catch(err => {
                    alert(err.response.data.message);
                });
            },

            deleteAnswer() {
                if (confirm('Are you sure?')) {
                    axios.delete(this.endpoint)
                        .then(
                            res => {
                                $(this.$el).fadeOut(500, () => {
                                    alert(res.data.message);
                                })
                            }
                        )
                        .catch(err => {
                            alert(err.response.data.message);
                        })
                }
            }
        }
    }
</script>
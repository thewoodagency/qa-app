<template>
    <div>
        <span class="text-muted">from Vue - {{ postDate }}</span>
        <div class="media mt-2">
            <a :href="user.url" class="pr-2">
                <img :src="user.avatar"/>
            </a>
            <div class="media-body mt-1">
                <a :href="user.url">{{ user.email }}</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "UserInfo",
        props: ['model', 'label'], //<user-info model='prop1' label='prop2'></user-info>
        computed: {
            postDate() {
                return this.label + " " + this.model.created_date;
            }
        },
        data() {
            return {
                user: this.model.user
            }
        }

    }
</script>

<style scoped>

</style>
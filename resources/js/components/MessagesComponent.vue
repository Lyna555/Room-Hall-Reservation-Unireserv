<template>
    <div class="card user-box">
        <div class="card-header" @click="collapsed = !collapsed">
            {{ chat.name }}
        </div>
        <div class="card-body" v-show="!collapsed">
            <div class="user-messages">
                <div
                    class="chat-message"
                    v-for="message in messages"
                    v-bind:key="message.id"
                    v-bind:class="[(message.user.id == username) ? 'from-client' : 'from-admin']"
                >
                    {{ message.text }}
                </div>
            </div>
            <div class="input-container">
                <input
                    class="chat-input"
                    type="text"
                    placeholder="enter message..."
                    v-model="message"
                    v-on:keyup.enter="addMessage"
                    @enter="addMessage"
                >
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['client', 'chat', 'autheduser'],
    data() {
        return {
            message: "",
            messages: [],
            collapsed: false,
            channel: null
        }
    },
    computed: {
        username() {
            return this.autheduser.email.replace(/[@\.]/g, '_')
        }
    },
    async created() {
    },
    methods: {
    }
}
</script>
<template>
    <div class="active-chats row">
         <message-component
            v-for="chat in activeChats"
            :key="chat.id"
            :token="token"
            :client="client"
            :chat="chat"
            :autheduser="autheduser">
         </message-component>
    </div>
</template>

<script>
import { StreamChat } from 'stream-chat';
export default {
    props: ['autheduser'],
    data () {
        return {
            activeChats: [],
            client: null,
            token: null,
        }
    },
    created() {
        this.EventBus.$on('newActiveChat', user => {
            // check if the user chat is already present
            const chat = this.activeChats.find(chat => chat.email == user.email)
            if (!chat) {
                this.activeChats.push(user)
                // remove the first chat head if the number of chat head is
                // greater than the MAX_NO_CHAT_HEAD
                if (this.activeChats.length > this.MAX_NO_CHAT_HEAD) {
                    this.activeChats.shift()
                }
            }
        })
    },
    methods: {
    }
}
</script>
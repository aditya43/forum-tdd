<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
                <textarea name="body" id="body" class="form-control" placeholder="Have something to say?" rows="5" v-model="body" required></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" @click="addReply">Post Reply</button>
            </div>
        </div>
        <p class="text-center" v-else>
            Please
            <a href="/login">sign in</a> to participate in this discussion.
        </p>
    </div>
</template>

<script>
export default {
    computed: {
        signedIn() {
            return window.App.signedIn;
        }
    },
    data() {
        return {
            body: ""
        };
    },

    methods: {
        addReply() {
            axios
                .post(location.pathname + "/replies", { body: this.body })
                .then(({ data }) => {
                    this.$emit("created", data);
                    this.body = "";
                    flash("Your reply has been posted.");
                });
        }
    }
};
</script>
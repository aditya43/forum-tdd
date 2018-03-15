<template>
    <div id="'reply-'+id" class="card bg-light mb-3">
        <div class="card-header">
            <div class="level">
                <div class="flex">
                    <a :href="'/profiles/'+data.owner.name" v-text="data.owner.name"></a>
                    replied {{ data.created_at }}
                </div>
                <div v-if="signedIn">
                    <favourite :reply="data"></favourite>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>

                <button class="btn btn-primary btn-sm" @click="update">Update</button>
                <button class="btn btn-link" @click="editing=false">Cancel</button>
            </div>

            <div class="body" v-else v-text="body"></div>
        </div>

        <div class="card-footer level" v-if="canUpdate">
            <button class="btn btn-sm mr-2" @click="editing=true">Edit</button>
            <button class="btn btn-danger btn-sm" @click="destroy()">Delete</button>
        </div>
    </div>
</template>

<script>
import Favourite from "./Favourite.vue";

export default {
    props: ["data"],

    components: { Favourite },

    computed: {
        signedIn() {
            return window.App.signedIn;
        },

        canUpdate() {
            return this.authorize(user => this.data.user_id == user.id);
        }
    },

    data() {
        return {
            editing: false,
            id: this.data.id,
            body: this.data.body
        };
    },

    methods: {
        update() {
            axios.patch("/replies/" + this.data.id, {
                body: this.body
            });
            this.editing = false;
            flash("Reply has been updated.");
        },

        destroy() {
            let res = confirm("Are you sure you want to delete this reply?");
            if (res) {
                axios.delete("/replies/" + this.data.id);
                this.$emit("deleted", this.data.id);
            }
        }
    }
};
</script>
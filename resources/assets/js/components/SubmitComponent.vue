<template>
    <div class="card">
        <div class="card-header">投稿する</div>

        <div class="card-body">
            <div>
                <div class="form-group row">
                    <label for="date-input" class="col-2 col-form-label">日付</label>
                    <div class="col-10">
                        <input v-model="datetime"  class="form-control" type="date" id="date-input">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputTextarea" class="col-sm-2 col-form-label">日記</label>
                    <div class="col-sm-10">
                        <textarea v-model="content" placeholder="今日はどうだった？" class="form-control" id="inputTextarea" rows="4"></textarea>
                    </div>
                </div>
                <button class="btn btn-primary" v-bind:disabled='!canPush' v-on:click="handleClick">投稿する</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            datetime : '',
            content: '',
        }
    },
    methods: {
        handleClick: function() {
            axios.post('/api/diary', {
                diary: {
                    datetime: this.datetime,
                    content: this.content,
                }
            }).then(response => {
                window.location.href = '/home'
            }, error => {
                console.log(error)
            });
        },
        getNowYMD: function() {
            var dt = new Date();
            var y = dt.getFullYear();
            var m = ("00" + (dt.getMonth()+1)).slice(-2);
            var d = ("00" + dt.getDate()).slice(-2);
            var result = y + "-" + m + "-" + d;
            return result;
        }
    },
    computed: {
        canPush () {
            return this.datetime && this.content
        }
    },
    mounted() {
        this.datetime = this.getNowYMD()
    },
}
</script>

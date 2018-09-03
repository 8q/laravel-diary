<template>
    <div>
        <div class="card">
            <div class="card-header">{{ diary.datetime }}</div>

            <div class="card-body">
                {{ diary.content }}
            </div>
        </div>
        <br />
    </div>
</template>

<script>
export default {
    props: ['diary']
}
</script>

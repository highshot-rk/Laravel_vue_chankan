<template>
	<div class="process-table-thead">
        <div class="process-table-tr" >
            <div class="process-table-th day"></div>
            <div class="process-table-th first">AM / PM</div>
            <draggable
                id="table-header"
                v-if="reset"
                style="display:flex" group="nameGroup"
                @end="dragEnd($event)"
                :disabled="tableHeaderEnable"
            >
                <div  v-for="(manager, index) in managers" :key="index" class="process-table-th name" style="cursor:pointer">
                    {{ manager.name.substr( 0, 8 ) }}
                </div>
            </draggable>
            <!-- <div v-for="(manager, index) in managers" :key="index" class="process-table-th name">{{ manager.name.substr( 0, 8 ) }}</div> -->
        </div>
	</div>
</template>

<script>
	import draggable from 'vuedraggable'

    var origin_height;
    var full_height;
	export default {
		components: {
			draggable,
		},
        data: function () {
            return {
                reset: true,
                correct_height: 0,
            }
        },
        filters: {},
        mounted: function() {

            window.addEventListener('load', function () {
                const scrolling = document.getElementById("crm");
                console.log(scrolling.scrollTop, "origin_height")
                origin_height = scrolling.scrollTop;
                setTimeout(()=>{
                    const full = document.getElementById("crm");
                    console.log(full.scrollTop, "full_loading_height")
                    full_height = full.scrollTop;
                }, 1000);
            })
        },
        computed: {
            calendars: function() {
                return this.$store.getters.getcalendars;
            },
            managers: function() {
                return this.$store.getters.getManagerLists;
            },
            tableHeaderEnable: function() {
                return !this.$store.getters.getTableHeaderEnable
            }
        },
        methods: {

            dragEnd(event){
                this.$store.commit('setTableHeaderEnable',false);
                setTimeout(()=>{

                    const scroll = document.getElementById("crm");
                    const current_height = scroll.scrollTop;
                    const diff_height = full_height-current_height;
                    const every_diff = full_height-origin_height;
                    if(diff_height < 820){
                        this.correct_height = current_height - every_diff;
                    }else{
                        this.correct_height = current_height - 312;
                    }
                    console.log(origin_height, 'origin', full_height,"full")
                    this.$store.commit('setScrollHeight', this.correct_height);
                    this.$store.commit('changeManagerList',event);
                    this.reset = false

                    this.$nextTick(()=>{
                        this.reset = true
                    })
                    this.$store.commit('setResetFlg',false);
                }, 3500);
            },
        },
        // @choose="chooseProcess(calendars[id], 'yetcolumns', lineNumber, target)"
        // @add="addProcess(id, 'yetcolumns', lineNumber, target)"
        // @remove="removeProcess(id, 'yetcolumns', lineNumber, target)"
	}
</script>

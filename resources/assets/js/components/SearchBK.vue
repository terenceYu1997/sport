<template>
    <div class="container">
        <div class="searchContainer">
            <h3 style="text-align: center;color:blue">马拉松成绩查询</h3>
            <el-form :inline="true" :model="formInline" class="demo-form-inline">
                <el-form-item label="选手编号">
                    <el-input v-model="formInline.playerNum" placeholder="选手编号"></el-input>
                </el-form-item>
                <el-form-item label="比赛编号">
                    <el-input v-model="formInline.raceNum" placeholder="比赛编号"></el-input>
                </el-form-item><el-form-item>
                <el-button type="primary" @click="getRaceinfo">查询</el-button>
            </el-form-item>
            </el-form>


            <div class="theTable">
                <el-table
                        :data="tableData"
                        border
                        style="width: 100%">
                    <el-table-column
                            :sortable="true"
                            prop="name"
                            label="姓名">
                    </el-table-column>
                    <el-table-column
                            :sortable="true"
                            prop="num"
                            label="编号">
                    </el-table-column>
                    <el-table-column
                            :sortable="true"
                            prop="grouprank"
                            label="排名"
                            >
                    </el-table-column>
                    <el-table-column
                            :sortable="true"
                            prop="scoretime"
                            label="比赛用时"
                            width="180">
                    </el-table-column>
                </el-table>
            </div>



        </div>

    </div>
</template>

<style src='./Search.css'></style>

<script>

    export default {
        data() {
            return {
                tableData: ''
                ,
                formInline: {
                    playerNum: '',
                    raceNum: ''
                }
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
        ,
        methods:{
            alertWorning(){
                this.$message({
                    message: '未找到人员信息',
                    type: 'warning'
                });
            }
            ,
            getRaceinfo(){
                axios.post('/api/v1/raceinfo',this.formInline,{

                }).then( (res) => {
                        this.tableData = res.data;
                        console.log(res)
                        if((res.data) == "z"){
                            this.alertWorning();
                        }
                    })
            }
        }
    }
</script>

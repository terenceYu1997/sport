<template>
    <div class="container">
        <div class="searchContainer">
            <h2 style="text-align: center;color:blue">马拉松成绩查询</h2>
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


        <div class="playerInfo">
            <div class="theScore">
                <span>
                    {{theScoreTime}}
                </span>
            </div>
            <div class="theMatchName">
                <span>
                    {{theLocation}}
                </span>
            </div>
            <div class="thePlayerName">
                <span class="big">
                    <span>{{thePlayerName}}</span>
                    <span class="tag">姓名</span>
                </span>
                <span class="big">
                    <span>{{theSex}}</span>
                    <span class="tag">性别</span>
                </span>
                <span class="big">
                    <span>{{theGroupRank}}</span>
                    <span class="tag">排名</span>
                </span>

            </div>


        </div>



        </div>

    </div>
</template>

<style src='./Search.css'></style>

<script>

    export default {
        data() {
            return {
                aa:"YTC"
                ,
                aa:"LZY"
                ,
                tableData: ''
                ,
                formInline: {
                    playerNum: '',
                    raceNum: ''
                },
                theScoreTime:'00:00:00',
                theMatchName:"Marathon",
                theLocation:"ShangHai",
                thePlayerName:'John',
                theGroupRank:'01',
                theSex:'Man',
                theNum:'01',
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
                var self = this;
                axios.post('/api/v1/raceinfo',this.formInline,{

                }).then( (res) => {
                    if((res.data) != "z"){

                        this.tableData = res.data;
                        this.theScoreTime = res.data[0].scoretime;
                        this.thePlayerName = res.data[0].name;
//                        this.theMatchName = res.data[0].scoretime;
                        this.theGroupRank = res.data[0].grouprank;
                        this.theSex = res.data[0].sex;
                        this.theNum  = res.data[0].num;
                        this.theLocation  = res.data[0].Location;
                        console.log(res);
                        console.log( this.theScoreTime)
                    }else{
                        this.theScoreTime='00:00:00';
                        this.theMatchName="Marathon";
                        this.thePlayerName='John';
                        this.theLocation='ShangHai';
                        this.theSex='Man';
                        this.theNum='01';
                        this.alertWorning();
                    }
                })
            }
        }
    }
</script>

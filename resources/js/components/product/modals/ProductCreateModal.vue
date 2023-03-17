<template>
    <el-dialog
        visible
        title="Create Product"
        @update:visible="close"
        top="5vh"
    >
        <el-form label-position="top" label-width="100px" ref="form" :inline="true">
            <el-row :span="20">
                <el-row>
                    <el-col :span="22" :offset="1">
                        <div v-for="error in errors" class="alert alert-danger">
                            {{ error[0] }}
                        </div>
                        <div v-if="success" class="alert alert-success">
                            {{ success }}
                        </div>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col :span="10" :offset="1">
                        <el-form-item label="Select language">
                            <select v-model="data.langId" placeholder="Select language">
                                <option value="">select languages</option>
                                <option v-for="item in languages" :value="item.id">{{ item.context }}</option>
                            </select>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-col :span="10" :offset="1">
                    <el-form-item label="Product name">
                        <el-input v-model="data.name"></el-input>
                    </el-form-item>
                    <el-form-item label="Product price" prop="desc">
                        <el-input v-model="data.price"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="10" :offset="2">
                    <el-form-item label="Product stock">
                        <el-input type="number" min="0" v-model="data.stock"></el-input>
                    </el-form-item>
                    <el-form-item label="Product currency">
                        <el-select v-model="data.currency" placeholder="Select currency">
                            <el-option label="AMD" value="AMD"/>
                            <el-option label="USD" value="USD"/>
                            <el-option label="RUB" value="RUB"/>
                        </el-select>
                    </el-form-item>
                </el-col>
            </el-row>
        </el-form>
        <template slot="footer">
            <el-button type="primary" @click="send">Submit</el-button>
        </template>
    </el-dialog>
</template>

<script>
import {
    Dialog as ElDialog,
    Input as ElInput,
    Select as ElSelect,
    Option as ElOption,
    Form as ElForm,
    FormItem as ElFormItem,
    Button as ElButton,
    Row as ElRow,
    Col as ElCol,
} from 'element-ui'

export default {
    name: "product-create-modal",
    components: {
        ElDialog,
        ElInput,
        ElSelect,
        ElOption,
        ElForm,
        ElFormItem,
        ElButton,
        ElRow,
        ElCol
    },
    data() {
        return {
            data: {
                langId: '',
                name: '',
                price: '',
                stock: '',
                currency: '',
            },
            errors: null,
            success: null,
            languages: null
        }
    },
    mounted() {
        this.getLanguages()
    },
    methods: {
        getLanguages() {
            this.$axios.get('languages')
                .then(response => {
                    this.languages = response.data
                })
                .catch(error => {
                    console.log(error)
                });
        },
        close() {
            this.$emit('close')
        },
        send() {
            console.log(this.$axios)
            this.$axios.post('products',
                {
                    lang_id: this.data.langId,
                    name: this.data.name,
                    price: this.data.price,
                    stock: this.data.stock,
                    currency: this.data.currency,
                }
            ).then((res) => {
                if (res.data.success) {
                    this.errors = null
                    this.success = res.data.message
                    setTimeout(() => location.reload(), 1500)
                }
            }).catch(error => {
                if (error.response) {
                    this.errors = error.response.data.errors
                }
            });
        }
    }
}
</script>

<style lang="scss" scoped>

</style>

<div class="bjui-pageContent">
    <form action="{:url('')}" class="pageForm" data-toggle="validate">
        <input type="hidden" name="dialog.id" value="edce142bc2ed4ec6b623aacaf602a4de">
        <table class="table table-condensed table-hover">
            <tbody>
                <!-- <tr>
                    <td colspan="2" align="center"><h3>* 我是一个弹出窗口</h3></td>
                </tr> -->
                <tr>
                    <td>
                        <label for="j_dialog_operation" class="control-label x90">上级菜单：</label>
                        <select name="info[parentid]" >
                            <option value="0">作为一级菜单</option>
                            <?php echo $select_categorys;?>
                        </select>
                    </td>
                    <td>
                        <label for="j_dialog_code" class="control-label x85">菜单名：</label>
                        <input type="text" name="info[name]" data-rule="required" size="20">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="j_dialog_name" class="control-label x90">文件名：</label>
                        <input type="text" name="info[c]" data-rule="required" size="20" value="{$parentDetail.c}">
                    </td>
                    <td>
                        <label for="j_dialog_tel" class="control-label x85">方法名：</label>
                        <input type="text" name="info[a]" data-rule="required" size="20">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <label for="j_dialog_profession" class="control-label x90">排序：</label>
                        <input type="text" name="info[listorder]" value="0" data-rule="required" size="20">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <label for="j_dialog_display" class="control-label x85">是否显示：</label>
                        <input type="radio" name="info[display]" id="j_dialog_display_yes" value="1" data-toggle="icheck" data-label="显示" checked>
                        <input type="radio" name="info[display]" id="j_dialog_display_no" value="0" data-toggle="icheck" data-label="隐藏">
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close">关闭</button></li>
        <li><button type="submit" class="btn-default">保存</button></li>
    </ul>
</div>
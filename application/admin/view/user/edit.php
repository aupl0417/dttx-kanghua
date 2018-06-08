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
                        <label for="j_dialog_name" class="control-label x90">用户名：</label>
                        {empty name="Detail"}
                        <input type="text" name="info[username]" data-rule="required;remote[{:url('System/ajax_checkUsername')}]" size="20" value="{$Detail.username}">
                        {else /}
                        <input type="text" name="info[username]" disabled size="20" value="{$Detail.username}">
                        {/empty}
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="j_dialog_tel" class="control-label x90">昵称：</label>
                        <input type="text" name="info[nickname]" size="20" value="{$Detail.nickname}">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="j_dialog_profession" class="control-label x90">角色：</label>
                        <select data-toggle="selectpicker" name="info[roleid]">
                            {foreach name="roles" key="key" item="role"}
                            <option value="{$key}" {eq name="Detail.roleid" value="$key"}selected{/eq}>{$role[rolename]}</option>
                            {/foreach}
                        </select>
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
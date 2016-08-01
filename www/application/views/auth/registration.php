<style>
td {
	padding: 0 10px;
}
</style>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <!--Начало формы регистрации-->
    <form id="register_form" name="register_form" method="post" action="antisclick/auth/reg">
        <table width="350" height="315" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFF">
            <tr>
                <td align="right">
                    <b>first_name:</b>
                    <input type="text" name="first_name" id="first_name" />
                </td>
            </tr>
            <tr>
                <td align="right">
                    <b>last_name:</b>
                    <input type="text" name="last_name" id="last_name" />
                </td>
            </tr>
            <tr>
                <td align="right"><b>E-Mail:</b>
                    <input type="text" name="email" id="email" />
                </td>
            </tr>
            <tr>
                <td align="right"><b>Пароль:</b>
                    <input type="password" name="password" id="password" />
                </td>
            </tr>
            <tr>
                <td align="right"><b>Повторите пароль:</b>
                    <input type="password" name="password_confirm" id="password_confirm" />
                </td>
            </tr>
            
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" name="reg_button" id="reg_button" value="Готово" />
                </td>
            </tr>
        </table>
    </form>
    <!--Конец формы регистрации-->
</div>

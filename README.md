# Agi_asterisk.php
URA com AGI em PHP no Asterisk

Esse AGI possui três opções, a primeira liga para um determinado ramal, a segunda disca para uma fila interna, a terceira recebe
o DTMF digitado pelo usuário, após o mesmo digitar o CPF é consultado no banco de dados se o mesmo existir é retornado um áudio
que o CPF existe e o mesmo é retornado para uma variável no Asterisk sendo possível recuperar a informação no próprio Dialplan,
caso não existente é informado que o cpf não existe e a ligação é direcionada para um ramal.

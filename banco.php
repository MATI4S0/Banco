<?php 

const CHEQUE_ESPECIAL = 500;
$clientes = [];

// ======================= CADASTRAR CLIENTE =======================
function cadastrarCliente(array &$clientes): bool {

    $nome = readline('Informe seu nome: ');
    $cpf  = readline('Informe seu CPF: ');

    if (isset($clientes[$cpf])) {
        print("Esse CPF já possui cadastro.\n");
        return false;
    }

    $clientes[$cpf] = [
        'nome' => $nome,
        'cpf' => $cpf,
        'contas' => []
    ];

    print "Cliente cadastrado com sucesso!\n";
    return true;
}

// ======================= CADASTRAR CONTA =======================
function cadastrarConta(array &$clientes): bool {

    $cpf = readline("Informe seu CPF: ");

    if (!isset($clientes[$cpf])) {
        print "Cliente não possui cadastro.\n";
        return false;
    }

    $numConta = rand(10000, 99999);

    $clientes[$cpf]['contas'][$numConta] = [
        'conta' => $numConta,
        'saldo' => 0,
        'cheque_especial' => CHEQUE_ESPECIAL,
        'extrato' => []
    ];

    print "Conta criada com sucesso!\n";
    print "Número da conta: #{$numConta}\n";
    return true;
}

// ======================= ADICIONAR AO EXTRATO =======================
function adicionarAoExtrato(array &$clientes, $cpf, $numConta, $frase) {

    $dataHora = date('d/m/Y H:i');
    $clientes[$cpf]['contas'][$numConta]['extrato'][] = "($dataHora) $frase";

}

// ======================= DEPOSITAR =======================
function depositar(array &$clientes){
    $cpf = readline("Informe seu CPF novamente: ");

    if (!isset($clientes[$cpf])) {
        print "CPF não encontrado.\n";
        return false;
    }

    $numConta = readline("Informe o número da conta: ");

    if (!isset($clientes[$cpf]['contas'][$numConta])) {
        print "Conta inexistente.\n";
        return false;
    }

    $valorDeposito = (float) readline("Informe o valor do depósito: ");

    if ($valorDeposito <= 0) {
        print "Valor de depósito inválido.\n";
        return false;
    }

    $clientes[$cpf]['contas'][$numConta]['saldo'] += $valorDeposito;

    adicionarAoExtrato($clientes, $cpf, $numConta, "Depósito de R$ $valorDeposito.");

    print "Depósito realizado com sucesso!\n";
    return true;
}

// ======================= SACAR =======================
function sacar(array &$clientes){

    $cpf = readline("Informe seu CPF: ");

    if (!isset($clientes[$cpf])) {
        print "Cliente não possui cadastro.\n";
        return false;
    }

    $conta = readline("Informe o número da conta: ");

    if (!isset($clientes[$cpf]['contas'][$conta])) {
        print "Conta inexistente.\n";
        return false;
    }

    $valorSaque = (float) readline("Informe o valor do saque: ");

    $saldo = $clientes[$cpf]['contas'][$conta]['saldo'];
    $limite = $saldo + $clientes[$cpf]['contas'][$conta]['cheque_especial'];

    if ($valorSaque > $limite) {
        print "Saque não autorizado. Valor excede saldo + cheque especial.\n";
        return false;
    }

    $clientes[$cpf]['contas'][$conta]['saldo'] -= $valorSaque;

    adicionarAoExtrato($clientes, $cpf, $conta, "Saque de R$ $valorSaque.");

    print "Saque realizado com sucesso!\n";
    return true;
}

// ======================= CONSULTAR SALDO =======================
function consultarSaldo(array $clientes){

    $cpf = readline("Informe seu CPF: ");

    if (!isset($clientes[$cpf])) {
        print "Cliente não encontrado.\n";
        return false;
    }

    $conta = readline("Informe o número da conta: ");

    if (!isset($clientes[$cpf]['contas'][$conta])) {
        print "Conta inexistente.\n";
        return false;
    }

    $saldo = $clientes[$cpf]['contas'][$conta]['saldo'];
    $limite = $clientes[$cpf]['contas'][$conta]['cheque_especial'];

    print "\n---- SALDO ----\n";
    print "Conta: $conta\n";
    print "Saldo: R$ $saldo\n";
    print "Cheque especial: R$ $limite\n";
    print "Limite total disponível: R$ " . ($saldo + $limite) . "\n";

    return true;
}

// ======================= CONSULTAR EXTRATO =======================
function consultarExtrato(array $clientes){

    $cpf = readline("Informe seu CPF: ");

    if (!isset($clientes[$cpf])) {
        print "Cliente não encontrado.\n";
        return false;
    }

    $conta = readline("Informe o número da conta: ");

    if (!isset($clientes[$cpf]['contas'][$conta])) {
        print "Conta inexistente.\n";
        return false;
    }

    print "\n======= EXTRATO DA CONTA $conta =======\n";

    if (empty($clientes[$cpf]['contas'][$conta]['extrato'])) {
        print "Nenhuma movimentação ainda.\n";
        return true;
    }

    foreach ($clientes[$cpf]['contas'][$conta]['extrato'] as $item) {
        print "$item\n";
    }

    print "=======================================\n";

    return true;
}

// ======================= MENU =======================
function menu(){
    print "\n====== MEU BANCO EM PHP ======\n";
    print "1 - Cadastrar cliente\n";
    print "2 - Cadastrar conta\n";
    print "3 - Depositar\n";
    print "4 - Sacar\n";
    print "5 - Consultar saldo\n";
    print "6 - Consultar extrato\n";
    print "7 - Sair\n";
    print "===============================\n";
    print "Escolha uma opção: ";
}

while(true){

    menu();
    $opcao = readline();

    switch ($opcao) {

        case '1':
            cadastrarCliente($clientes);
            break;

        case '2':
            cadastrarConta($clientes);
            break;

        case '3':
            depositar($clientes);
            break;

        case '4':
            sacar($clientes);
            break;

        case '5':
            consultarSaldo($clientes);
            break;

        case '6':
            consultarExtrato($clientes);
            break;

        case '7':
            print "Obrigado por usar nosso banco!\n";
            die();

        default:
            print "Opção inválida.\n";
            break;
    }
}

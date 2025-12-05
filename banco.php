<?php 

const CHEQUE_ESPECIAL = 500;
$clientes = [];

function cadastrarCliente(&$clientes): bool {

    $nome = readline('Informe seu nome: ');
    $cpf  = readline('Informe seu CPF: ');

    //validar cliente
    if (isset($clientes[$cpf])) {
        print('Esse CPF já possui cadastro.\n');
        return false;
    }

    $clientes[$cpf] = [
        'nome' => $nome, 
        'cpf' => $cpf,
        'contas' => []
    ];
 if ($cpf ) {
        # code...
    }

    return true;
}

function cadastrarConta(array &$clientes): bool {

    $cpf = readline("Informe seu CPF:");

    if (!isset($clientes[$cpf])) {
        print "Cliente não possui cadastro \n";
        return false;
    }

    $numConta = rand(10000, 100000);

    $clientes[$cpf]['contas'][$numConta] = [
        'conta' => $numConta,
        'saldo' => 0,
        'cheque_especial' => CHEQUE_ESPECIAL,
        'extrato' => []
    ];

    print "Conta criada com sucesso\n";
    print "O número da sua conta é: #{$numConta}";
    return true;

}

function depositar(array &$clientes){
    $cpf = readline("Informe seu CPF novamente: ");

    $numConta = readline("Informe o número da conta:");

    $valorDeposito = (float) readline("Informe o valor do depósito: ");

    if ($valorDeposito <= 0) {
        print "Valor de depósito inválido\n";
        return false;
    }

    $clientes[$cpf]['contas'][$numConta]['saldo'] += $valorDeposito;

    adicionarAoExtrato($cpf, $numConta, "Deposito de $valorDeposito realizado.");


    print "Depósito realizado com sucesso\n";
    return true;
}

function sacar(&$clientes){

    $cpf = readline("informe seu CPF:");

    //validacao do CPF
    if (!isset($clientes[$cpf])) {
        print "Cliente não possui cadastro \n";
        return false;
    }
    $conta = readline("informe o número da conta: ");
    $valorSaque = readline("Informe o valor do saque:");

    if ($clientes[$cpf]['contas'][$conta]['saldo'] >= $valorSaque) {
        $clientes[$cpf]['contas'][$conta]['saldo'] -= $valorSaque;
    }else{
        print "Não foi possível sacar";
        return false;
    }

    adicionarAoExtrato($cpf, $conta, "Saque de $valorSaque realizado.");

    print "Saque realizado com sucesso\n";
    return true;

}

function consultarCliente($clientes){

    $cpf = readline("informe seu CPF:");

    //validacao do CPF
    if (!isset($clientes[$cpf])) {
        print "Cliente não possui cadastro \n";
        return false;
    }

    print "nome: " . ($clientes[$cpf]['nome']);
    print "CPF: " . ($clientes[$cpf]['cpf']);


    foreach ($clientes[$cpf]['contas'] as $conta) {
       print $conta['conta'] . "\n";
       print $conta['saldo'] . "\n";

       foreach ($conta['extrato'] as $item_extrato) {
            print $item_extrato . "\n";
       }
    }

}

function adicionarAoExtrato($cpf, $numConta, $frase){

    $dataHora = date('d/m/Y H:i');
    $clientes[$cpf]['contas'][$numConta]['extrato'][] = "($dataHora) $frase";

}

// MENU PRINCIPAL
function menu(){
    print "\n====== MEU BANCO EM PHP ======\n";
    print "1 -    cadastrar cliente      |\n";
    print "2 -    cadastrar conta        |\n";
    print "3 -    depositar              |\n";
    print "4 -    sacar                  |\n";
    print "5 -    consultar saldo        |\n";
    print "6 -    consultar extrato      |\n";
    print "7 -    sair                   |\n";
    print "===============================\n";
    print "Escolha uma opção:";
}


//PROGRAMA PRINCIPAL
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
            consultarCliente($clientes);
            break;
        
        case '7':
            print "Obrigado por usar nosso banco";
            die();
        
        default:
            print "Opção inválida";
            break;
    }
}

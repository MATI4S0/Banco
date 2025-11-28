<?php

    const   CHEQUE_ESPECIAL = 500;

    $clientes = [];

    function cadastrarClientes(&$clientes): bool {

        $nome = readline ('informe seu nome: ');

        $cpf = readline ('Informe seu CPF: ');

        if (isset($clientes[$cpf])) {
            print ("Este usuario já possui cadastro \n");
            return false; 
        }

        $clientes[$cpf] = [
            'nome' => $nome,
            'CPF' => $cpf,
            'contas' => []

        ];
        return true;
    

}



    function cadastrarConta(array &$clientes): bool{

        $cpf = readline("Informe seu CPF: ");

        if (!isset($clientes[$cpf])){
            print "Cliente não possui cadastro \n";
            return false;
        }

        $numConta = uniqid();

        $clientes[$cpf]['contas'][$numConta]= [
            'saldo' => 0,
            'cheque_especial' => CHEQUE_ESPECIAL,
            'extrato' => []
        ];
        print "Conta criada com sucesso \n";
        return true;

    }
    

    function depositar(&$clientes){
        $cpf = readline("Informe seu CPF: ");

        $numConta = readline("Informe o número da conta: ");

        $valorDeposito = (float) readline("Informe o valor do depósito: ");

        if ($valorDeposito <= 0) {
            print "Valor de depósito inválido\n";
            return false;

        }

        $clientes[$cpf]['contas'][$numConta]['saldo'] += $valorDeposito;

        $dataHora = date('d/m/Y H:i');
        $clientes[$cpf]['contas'][$numConta]['extrato'][] = "Depósito de R$ $valorDeposito em $dataHora";


        print "Depósito realizado com sucesso\n";
        return true;

    }

    function lobby(){
    print "===========================\n";
    print "       MENU DO BANCO       \n";
    print "===========================\n";
    print "[1] cadastrar cliente      \n";
    print "[2] cadastrar conta        \n";
    print "[3] depositar              \n";
    print "[4] sacar                  \n";
    print "[5] consultar saldo        \n";
    print "[6] consultar extrato      \n";
    print "[7] sair                   \n";
    print "===========================\n";

    print "Escolha uma opção: \n";
    }

    while(true){

        lobby();


        $opcao = readline();

        switch ($opcao) {
            case '1':
                cadastrarClientes($clientes);
                break;

            case '2':
                cadastrarConta($clientes);
                break;

            case '3':
                depositar($clientes);
                break;

            case '7':
                print "Obrigado por usar nosso banco";
                die();
            
            default:
                print "Opção inválida";
                break;
        }

    }


    cadastrarClientes($clientes);
    print_r($clientes);

    cadastrarConta($clientes);
    print_r($clientes);

    depositar($clientes);
    print_r($clientes);

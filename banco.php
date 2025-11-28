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


    cadastrarClientes($clientes);
    print_r($clientes);

    cadastrarConta($clientes);
    print_r($clientes);

    depositar($clientes);
    print_r($clientes);

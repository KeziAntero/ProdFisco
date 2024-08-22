-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2021 at 08:25 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prod`
--

-- --------------------------------------------------------

--
-- Table structure for table `prod`
--

CREATE TABLE `fiscais` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nome` varchar(255) NOT NULL,
    `matricula` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE `service_type` (
    `service_id` int(11) NOT NULL AUTO_INCREMENT,
    `service_name` varchar(255) NOT NULL,
    `service_value` decimal(10,2) NOT NULL,
    PRIMARY KEY (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO service_type (service_name, service_value) VALUES
('Abertura de processo', 0.10),
('Alteração cadastral imobiliária', 0.20),
('Alteração cadastral no mercantil', 0.20),
('Analise e despacho', 1.00),
('Apuração acima de R$ 16.000,01', 10.00),
('Apuração de R$ 1,00 a R$ 500,00', 1.00),
('Apuração de R$ 1.001,00 a R$ 3.000,00', 2.50),
('Apuração de R$ 10.001,00 a R$ 16.000,00', 8.00),
('Apuração de R$ 3.001,00 a R$ 5.000,00', 3.00),
('Apuração de R$ 5.001,00 a R$ 8.000,00', 4.00),
('Apuração de R$ 501,00 a R$ 1.000,00', 2.00),
('Apuração de R$ 8.001,00 a R$ 10.000,00', 6.00),
('Apuração, Proposição e/ou Lavratura de Auto de Infração Pagos', NULL),
('Atendimento (Geral)', 0.10),
('Atendimento para suporte NFS_e (Virtual)', 0.20),
('Atendimento para suporte NFS_e', 0.50),
('Atualização de IPTU', 0.30),
('Atualização no sistema', 0.30),
('Avaliação de ITIV', 1.50),
('Averiguação de estabelecimento comercial', 1.50),
('Baixa de Cadastro Imobiliário', 0.20),
('Cadastro de enumeração imobiliário', 0.10),
('Cadastro ignorado (Localização CPF)', 0.50),
('Cadastro imobiliário de oficio', 0.30),
('Cadastro imobiliário em campo', 0.40),
('Cadastro imóvel novo', 0.30),
('Cadastro mercantil de oficio', 0.40),
('Cadastro mercantil', 0.20),
('Certidão negativa', 0.10),
('Cobrança Feira livre', 2.00),
('Conclusão de O.S.', '1.00'),
('Confecção de Certidões ou Similar', 0.50),
('Confecção de croqui', 3.00),
('Confissão de débitos', 0.50),
('Consulta documentos auxiliares', 1.00),
('Consulta REDESIM', 1.00),
('Declaração de substituição de veículo', 0.50),
('Declaração de taxista', 0.20),
('Declaração de transferência de placa de aluguel para particular', 0.20),
('Despacho de reclamação', 1.00),
('Despacho de Restituição de Imposto', 1.00),
('Despacho final (Fiscalização cumprida)', 1.00),
('Digitalização de processo, por lauda', 0.10),
('Diligência devidamente notificada na pesquisa de fraudes, por endereço', 0.20),
('Embargos de Obras ou atividades', 2.00),
('Emissão de DAM, por unidade', 0.10),
('Entrega de termo de Confissão de dívida', 3.00),
('Fiscalização cumprida, por contribuinte (Homologação)', 2.00),
('Fiscalização de até 12 meses', 5.00),
('Fiscalização de até 24 meses', 7.00),
('Fiscalização especial, com dedicação exclusiva, por determinação do secretário, por dia', 3.00),
('Guia de sepultamento', 0.20),
('Inclusão de cadastro para taxista', 0.50),
('Indicação de contribuinte não localizado', 0.50),
('Indicação de contribuinte novo', 0.50),
('Indicação de eventos', 3.00),
('Informação em proposta fundamentada em consultas, ou requerimentos, de qualquer natureza (exceto defesa de Auto de Infração)', 2.00),
('Inscrição de débitos em Dívida ativa, por inscrição', 0.30),
('Jornada dupla', 2.00),
('Laudo e parecer fundamentado em consultas e requerimento, protocolo, ou processo judicial', 2.00),
('Lavratura do termo de encerramento de fiscalização', 2.00),
('Lavratura do termo de início de fiscalização', 1.00),
('Levantamento de ISS na fonte', 5.00),
('Levantamento fiscal cumprido por até 12 meses', 5.00),
('Levantamento fiscal cumprido por até 24 meses', 7.00),
('Levantamento fiscal por fração proporcional, até 06 meses', 3.00),
('Manifestação em defesa de auto de infração', 4.00),
('Nota fiscal avulsa', 0.10),
('Notificação de débitos em aberto ainda não inscritos em DA', 0.50),
('Notificação voluntaria sem OS', 0.20),
('Ordem de fiscalização cumprida com termo de conclusão', 1.00),
('Ordem de serviço cumprida, com embaraço, devidamente notificada', 1.00),
('Ordem de serviço não cumprida, com embaraço à fiscalização', 2.00),
('Parcelamento', 0.10),
('Parecer de reclamação de lançamento', 2.00),
('Plantão fiscal – em cumprimento da escala normal, por dia', 2.00),
('Por fração proporcional, até 06 meses', 3.00),
('Prescrição de débitos (por exercícios)', 0.10),
('Relatório de encaminhamento ao MP', 2.00),
('Separação e organização dos carnes de IPTU', 0.30),
('Serviço concluído COM contagem dos ingressos e apuração da receita, por show', 2.00),
('Serviço concluído SEM contagem dos ingressos e apuração da receita, por show', 1.00),
('Suspensão de atividade mercantil', 0.20),
('Termo de início de fiscalização', 1.00),
('Verificação da falta de recolhimento de tributos', 0.50),
('Verificação em doc. Auxiliares no levantamento fiscal, na falta dos livros, e/ou notas fiscais, por exercício', 0.50),
('Verificação em livros contábeis', 2.00),
('Verificação em livros fiscais instituídos pela municipalidade', 0.20),
('Visita para avaliação, medição e lançamento', 1.00);


CREATE TABLE `prod_order` (
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_receiver_name` varchar(255) NOT NULL,
  `order_receiver_matricula` varchar(255) NOT NULL,
  `order_total_before_tax` varchar(255) NOT NULL,
  `order_total_tax` varchar(255) NOT NULL,
  `order_tax_per` varchar(255) NOT NULL,
  `order_total_after_tax` varchar(255) NOT NULL,
  `order_amount_paid` varchar(255) NOT NULL,
  `order_total_amount_due` varchar(255) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `note` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------
--
-- Table structure for table `prod_order_item`
--

CREATE TABLE `prod_order_item` (
  `order_id` int(11) NOT NULL,
  `item_code` varchar(255) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `order_item_quantity` varchar(255) NOT NULL,
  `order_item_qtdfiscal` varchar(255) NOT NULL,
  `order_item_price` varchar(255) NOT NULL,
  `order_item_final_amount` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Table structure for table `prod_user`
--

CREATE TABLE `prod_user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;



--
-- Indexes for dumped tables
--

--
-- Indexes for table `prod_order`
--
ALTER TABLE `prod_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `prod_user`
--
ALTER TABLE `prod_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `prod_order`
--
ALTER TABLE `prod_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `prod_user`
--
ALTER TABLE `prod_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

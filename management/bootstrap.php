<?php 
/**
 * Management bootstrap
 * php version 7.3.11
 */
declare(strict_types=1);
namespace management;
use \management\actions as act;
use \management\notifications as ntf;
use \management\statistics as stats;

ActionLocator::addAction(act\Help::factory());
ActionLocator::addAction(act\CurrencyTool::factory());
ActionLocator::addAction(act\Migration::factory());
ActionLocator::addAction(act\Users::factory());
ActionLocator::addAction(act\UnitTest::factory());
ActionLocator::addAction(stats\UpdateAccountStaticFields::factory());
ActionLocator::addAction(ntf\efdd\EmptyFieldDueDate::factory());
ActionLocator::addAction(ntf\efdr\EmptyFieldDebtRepaiment::factory());
ActionLocator::addAction(ntf\isow\InvoiceShipmentOneWeek::factory());
ActionLocator::addAction(ntf\istw\InvoiceShipmentTwoWeeks::factory());
ActionLocator::addAction(ntf\iwpo\InvoiceWithoutPurchaseOrder::factory());
ActionLocator::addAction(ntf\ns4d\NoticeShipping4Days::factory());
ActionLocator::addAction(ntf\nsw7d\NotShippedWithin7Days::factory());
ActionLocator::addAction(ntf\p2d\Payment2Days::factory());
ActionLocator::addAction(ntf\p2w\Payment2Weaks::factory());
ActionLocator::addAction(ntf\ufdd\UpdateFieldDueDate::factory());
ActionLocator::addAction(ntf\uqdd\UpdateQuoteDueDate::factory());
ActionLocator::addAction(ntf\updsa\UpdateSpecialAccount::factory());
ActionLocator::addAction(ntf\nttw\NotTakenToWork::factory());

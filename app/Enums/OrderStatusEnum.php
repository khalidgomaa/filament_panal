<?php
namespace app\Enums;

enum OrderStatusEnum : string {
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';
    case DECLINED = 'declined';
  
   
}
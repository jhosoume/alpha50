<?php
    function sql_recent_daily_quotes() {
      return 
      'SELECT a.*, c.*
      FROM daily_quotes a
      LEFT JOIN (
          SELECT id, MAX(date) AS MaxDate
          FROM daily_quotes
          GROUP BY id
      ) b ON a.id = b.id AND a.date = b.MaxDate 
      LEFT JOIN (
        SELECT *
          FROM stocks
      ) c ON a.stock_id = c.id
      ORDER BY a.date 
      DESC LIMIT 50;';      
    }


    function sql_recent_half_hourly_quotes() {
      return
      'SELECT a.*, c.*
      FROM half_hourly_quotes a
      LEFT JOIN (
          SELECT id, max(datetime) AS MaxDatetime
          FROM half_hourly_quotes
          GROUP BY id
      ) b on a.id = b.id and a.datetime = b.MaxDatetime
      LEFT JOIN (
        SELECT *
          FROM stocks
      ) c ON a.stock_id = c.id
      ORDER BY a.datetime 
      DESC LIMIT 50;';  
    } 
  
<?php

namespace App\Services;

use App\Models\Log;

class LogService
{

    private $origin;

    public function setOrigin($type, $id)
    {
        // TODO This system of determining origin is NOT solid at all, and im not advanced enough at Laravel to solve this in a nice OO way. More research needed.
        $this->origin['type'] = $type;
        $this->origin['id'] = $id;
    }

    public function store(array $data)
    {
        $log = Log::create($data);

        $log->save();

        return $log;
    }

    public function update(array $data, Log $log)
    {
        $log->update($data);

        $log->save();

        return $log;
    }

    public function delete(Log $log)
    {
       $log->delete();

       return $log;
    }

    public function findById($id)
    {
       $log = Log::find($id);

       return $log;
    }

    public function findAll()
    {
       $logs = Log::orderBy('created_at', 'desc')->get();

       return $logs;
    }

    public function getLogLevel($level)
    {
        switch ($level) {
            case 'emergency':
                return 1;
                break;
            
            case 'alert':
                return 2;
                break;
    
            case 'critical':
                return 3;
                break;

            case 'error':
                return 4;
                break;

            case 'warning':
                return 5;
                break;
            
            case 'notice':
                return 6;
                break;
            
            case 'info':
                return 7;
                break;

            case 'debug':
                return 8;
                break;
            
            default:
                return 4;
                break;
        }
    }

    public function loggable($level, $threshold = 'env')
    {
        if($threshold == 'env') {
            $threshold = config('logging.level');
        }

        if(self::getLogLevel($threshold) >= self::getLogLevel($level)) {
            return true;
        } else {
            return false;
        }
    }

    public function push($level, $title, $message = '', $stacktrace = '')
    {
        if(self::loggable($level)) {
            if($this->origin) {
                $log = Log::create([
                    'level' => $level,
                    'title' => $this->origin['type']  . ' ['. $this->origin['id'] . '] ' . $title,
                    'message' => $message,
                    'stacktrace' => $stacktrace
                ]);
            } else {
                $log = Log::create([
                    'level' => $level,
                    'title' => (auth()->user()->name ?? 'A task')  . ' ['. (auth()->user()->id ?? '-') . '] ' . $title,
                    'message' => $message,
                    'stacktrace' => $stacktrace
                ]);
            }

            return $log;
        }

        return null;
    }
}
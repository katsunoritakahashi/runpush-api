<?php

namespace App\Http\Requests;

class ScheduleRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'date' => 'required|date',
            'houseWorkId' => 'required|exists:house_works,id',
            'startTime' => 'required',
            'endTime' => 'required',
            'colorCode' => 'required|string',
            'repeatRule' => 'nullable|numeric',
            'repeatInterval' => 'nullable|numeric',
            'repeatEndDate' => 'nullable|date',
        ];
    }

    public function createParams()
    {
        return [
            'house_work_id' => $this->input('houseWorkId'),
            'color_code' => $this->input('colorCode'),
            'repeat_rule' => $this->input('repeatRule'),
            'repeat_interval' => $this->input('repeatInterval'),
            'repeat_end_date' => $this->input('repeatEndDate'),
            'start_at' => $this->input('date') . ' ' . $this->input('startTime'),
            'end_at' => $this->input('date') . ' ' . $this->input('endTime'),
        ];
    }
}

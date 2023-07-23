<?php

namespace App\Http\Resources;

use App\Enums\RepeatRule;
use Carbon\Carbon;

class ScheduleResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $date = $request->input('date');
        $completeAction = $this->actions()->isCompleted($date)->first();
        $startTime = Carbon::parse($this->start_at)->format('H:i:s');
        $endTime = Carbon::parse($this->end_at)->format('H:i:s');
        if (isset($this->repeat_rule)) {
            if ($this->repeat_rule == RepeatRule::Daily) {
                $displayRepeatRule = $this->repeat_interval == 1 ? '毎日' : $this->repeat_interval . '日ごと';
            } elseif ($this->repeat_rule == RepeatRule::Weekly) {
                $displayRepeatRule = $this->repeat_interval == 1 ? '毎週' : $this->repeat_interval . '週ごと';
            } elseif ($this->repeat_rule == RepeatRule::Monthly) {
                $displayRepeatRule = '毎月';
            }
        } else {
            $displayRepeatRule = null;
        }

        return [
            'id' => $this->id,
            'houseWork' => new HouseWorkResourceSummary($this->houseWork),
            'startTime' => $date . ' ' . $startTime,
            'endTime' => $date . ' ' . $endTime,
            'color' => $this->color_code,
            'status' => $completeAction ? '完了' : '未完了',
            'completedUser' => $completeAction ? $completeAction->user->name : null,
            'repeatRule' => $this->repeat_rule,
            'repeatInterval' => $this->repeat_interval,
            'repeatEndDate' => $this->repeat_end_date,
            'displayRepeatRule' => $displayRepeatRule,
        ];
    }
}

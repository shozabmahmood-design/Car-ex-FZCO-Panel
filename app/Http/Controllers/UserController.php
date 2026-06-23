<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use Carbon\Carbon;
use Doctrine\DBAL\Driver\IBMDB2\Driver;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function allUsers()
    {
        $users = User::with('profile')->where('user_type', 0)->orderBy('id', 'DESC')->get()->toArray();
        return $users;
    }

    public function allDrivers()
    {
        $users = User::with('profile')->where('user_type', 1)->orderBy('id', 'DESC')->get()->toArray();
        return $users;
    }

    public function delUser($userId)
    {
        User::find($userId)->delete();
        return response()->json(['message' => ' is deleted successfully']);
    }

    public function getAvailableDriversForBooking($booking_id)
    {
        $bookingToAssign = Booking::findOrFail($booking_id);

        $driversToFilter = collect();

        // First we get all the bookings that are currently in processing,
        // that drivers need to deliver and they have accepted the request.
        $bookings = Booking::query()
            ->where('status', Booking::DRIVER_ACCEPTED)
            ->orWhere('status', Booking::PENDING_DRIVER_APPROVAL)
            ->whereNotNull('assigned_to')
            ->get();

        // We determine the time at which the booking in question needs 
        // to be delivered
        $bookingToAssignStartTime = Carbon::parse($bookingToAssign->booking_date)
            ->addHours(explode(':', $bookingToAssign->booking_time)[0]);


        // We loop over all the bookings that need to be delivered and filter out
        // all the drivers that are busy at the booking in question's delivery time.
        foreach ($bookings as $booking) {
            // We get the time when the delivery should start
            $startDatetime = Carbon::parse($booking->booking_date)->addHours(explode(':', $booking->booking_time)[0]);
            // we get the time when delivery should be delivered completely. 
            // to do this we add the total hours plus *an extra hour* for the driver to rest. 
            $endDateTime = Carbon::parse($booking->booking_date)->addHours(explode(':', $booking->booking_time)[0])
                ->addHours($booking->totalHours  + 1);

            // we check if booking in questions delivery time is between the delivery time of
            // the current booking
            if ($bookingToAssignStartTime->isBetween($startDatetime, $endDateTime)) {
                // We filter out the driver's Id that is assigned to this booking
                $driversToFilter->push($booking->assigned_to);
            }
        }

        // we return all the remainig drivers i.e the drivers that are available
        return User::where('user_type', User::DRIVER)->whereNotIn('id', $driversToFilter)->get();
    }
}

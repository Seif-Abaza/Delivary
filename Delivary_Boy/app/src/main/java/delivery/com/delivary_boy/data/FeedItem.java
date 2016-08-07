package delivery.com.delivary_boy.data;

public class FeedItem {
    private int id;
    private String name, address, profilePic, starttime, quantaty, amount, phone;

    public FeedItem() {
    }

    public FeedItem(int id, String name, String address, String profilePic,
                    String starttime, String quantaty, String amount, String phone) {
        super();
        this.id = id;
        this.name = name;
        this.address = address;
        this.profilePic = profilePic;
        this.starttime = starttime;
        this.quantaty = quantaty;
        this.amount = amount;
        this.phone = phone;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getAddress() {
        return address;
    }

    public void setAddress(String address) {
        this.address = address;
    }

    public String getProfilePic() {
        return profilePic;
    }

    public void setProfilePic(String profilePic) {
        this.profilePic = profilePic;
    }

    public String getStarttime() {
        return starttime;
    }

    public void setStarttime(String stime) {
        this.starttime = stime;
    }

    public String getQuantaty() {
        return this.quantaty;
    }

    public void setQuantaty(String quantaty) {
        this.quantaty = quantaty;
    }

    public String getAmount() {
        return this.amount;
    }

    public void setAmount(String amount) {
        this.amount = amount;
    }

    public String getPhone() {
        return this.phone;
    }

    public void setPhone(String phone) {
        this.phone = phone;
    }
}

import java.util.Scanner;

class noob {
    public static void main (String[] args) {
        int t, n;
        Scanner sc = new Scanner(System.in);
        t = sc.nextInt();
        
        for (int x = 0; x < t; x++) {
            n = sc.nextInt();
            for (int i = 0; i < n; i++) {
                for (int j = 0; j < n; j++) {
                    if (i == j) {
                        System.out.print("1 ");
                    }
                    else {
                        System.out.print("0 ");
                    }
                } 
                System.out.println();
            } 
        } 
    }
}